<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import { h, onMounted, ref} from "vue";
import { useRoute } from 'vue-router';
import { useDialog } from 'openvue/usedialog';
import { useConfirm } from "openvue/useconfirm";
import { useRoleStore } from '../../stores/store-roles'
import { useRootStore } from "../../stores/root"
import { vaah } from "../../vaahvue/pinia/vaah";

import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';
import PermissionDetailsView from './components/PermissionDetailsView.vue';

const useVaah = vaah();
const store = useRoleStore();
const route = useRoute();
const root = useRootStore();

onMounted(async () => {

    /**
     * If record id is not set in url then
     * redirect user to list view
     */
    if(route.params && !route.params.id)
    {
        store.toList();
        return false;
    }

    /**
     * Fetch the record from the database
     */
    if (route.params && route.params.id) {
        await store.getItem(route.params.id);
    }

    /**
     * Fetch item permissions from the database
     */
    if (store.item && !store.role_permissions) {
        await store.getItemPermissions();
    }

    /**
     * Fetch permission menu item from store
     */
    await store.getPermissionMenuItems();

    /**
     * Fetch the permissions from the database
     */
    await root.getPermission();
});


//--------toggle item menu--------//
const permission_menu = ref();

const toggleItemMenu = (event) => {
    permission_menu.value.toggle(event);
};
//--------toggle item menu--------//


//--------toggle dynamic modal--------//
const dialog = useDialog();

const openViewModal = () => {
    const dialogRef = dialog.open(PermissionDetailsView, {
        props: {
            header: 'Details',
            style: {
                width: '50vw',
            },
            breakpoints:{
                '960px': '75vw',
                '640px': '90vw'
            },
            modal: true
        }
    });
}

//--------toggle dynamic modal--------//


//--------toggle confirm modal--------//
const confirm = useConfirm();

const confirmChangeStatus = (event, id) => {
    confirm.require({
        group: 'templating',
        message: store.assets.language_strings.changing_status_message,
        header: store.assets.language_strings.changing_status_dialogue,
        // M6-T5 — the icon was a palette literal (`text-red-600`), which
        // does not flip in dark mode, and it painted a status *change* as
        // a failure. The colour is the view's decision, not the icon
        // name's (reference-ui-conformance.md §3), and a status that has
        // not been switched on yet is a caution, not an error (§2): the
        // payload keeps the icon name and the tone is applied where the
        // icon is rendered.
        icon: 'pi pi-exclamation-circle',
        acceptProps: { class: 'p-button p-button-warn vc-dense' },
        acceptLabel:store.assets.language_strings.permission_status_change_button,
        rejectLabel:store.assets.language_strings.permission_status_cancel_button,
        rejectProps: { class: 'vc-dense btn-dark' },

        accept: () => {
            store.changeRoleStatus(id);
        },
    })
};
//--------toggle confirm modal--------//
</script>

<template>
    <div class="col-6">
        <Panel v-if="store && store.item" class="vc-dense">
            <template class="p-1" #header>
                <div class="flex flex-row">

                    <div class="font-semibold vc-text-16">
                        {{ store.item.name }}
                    </div>
                </div>
            </template>

            <template #icons>
                <InputGroup>

                    <Button size="small" class="" :label=" '#' + store.item.id" @click="useVaah.copy(store.item.id)" data-testid="role-permission_id" />

                    <!--/item_menu-->
                    <template v-if="store.hasPermission('can-update-roles')
                                    || store.hasPermission('can-manage-roles')"
                              class="control"
                    >
                        <Button size="small" class="" icon="pi pi-angle-down" aria-label="Show actions menu" type="button" aria-haspopup="true" @click="toggleItemMenu" data-testid="role-permission_menu" />

                        <Menu ref="permission_menu"
                              :model="store.permission_menu_items"
                              :popup="true"
                        />
                    </template>
                    <!--/item_menu-->

                    <Button size="small" class="" icon="pi pi-times" aria-label="Back to list" @click="store.toList()" data-testid="role-permission_list" />
                </InputGroup>
            </template>

            <div class="flex justify-content-between mt-3 mb-1">

                <div v-if="store && store.assets && store.assets.language_strings">
                    <Select v-model="store.role_permissions_query.module"
                              :options="store.assets.modules"
                              :placeholder="store.assets.language_strings.view_permissions_select_a_module"
                              data-testid="role-permission_module"
                              @change="store.getModuleSection()"
                              class="vc-dense"
                    >
                        <template #option="slotProps">
                            <div>
                                {{ slotProps.option.charAt(0).toUpperCase() + slotProps.option.slice(1) }}
                            </div>
                        </template>
                    </Select>
                </div>

                <div v-if="store.role_permissions_query.module && store.module_section_list"
                     class="mx-1"
                >
                    <Select v-model="store.role_permissions_query.section"
                              :options="store.module_section_list"
                              placeholder="Select a Section"
                              @click="store.getItemPermissions()"
                              data-testid="role-permission_section"
                              class="vc-dense"
                    >
                        <template #option="slotProps">
                            <div>
                                {{ slotProps.option.charAt(0).toUpperCase() + slotProps.option.slice(1) }}
                            </div>
                        </template>
                    </Select>
                </div>

                <Fluid class="grid">
                    <div class="col-12">
                        <!-- UT-108 (D3) — the search field and the "Reset"
                             button were welded into one `InputGroup`, so the
                             row read as a single oversized input with a button
                             stuck to its right edge — the defect the UT-108
                             cross-screen probe found on the list toolbars.
                             The field and its search glyph are one control and
                             stay together; "Reset" acts on the *list*, not on
                             the field, so it is a button of its own beside it
                             (the peer contract). -->
                        <div class="role-permission-search flex flex-wrap items-center gap-2">
                            <InputGroup class="role-permission-search-field">
                                <InputGroupAddon>
                                    <i class="pi pi-search" />
                                </InputGroupAddon>
                                <InputText aria-label="Search permissions" v-model="store.role_permissions_query.q"
                                           @keyup.enter="store.delayedRolePermissionSearch()"
                                           @keyup.enter.native="store.delayedRolePermissionSearch()"
                                           @keyup.13="store.delayedRolePermissionSearch()"
                                           :placeholder="store.assets?.language_strings?.view_permissions_placeholder_search"
                                           type="text"
                                           class="w-full"
                                           data-testid="role-permission_search"
                                />
                            </InputGroup>

                            <!-- UT-108 — `:fluid="false"` is load-bearing here.
                                 The v3 `<Fluid class="grid">` wrapper is a v4
                                 `<Fluid>` component, which *provides* a fluid
                                 context: every Button below it (at any depth)
                                 is rendered `p-button-fluid`, i.e.
                                 `width: 100%`. Inside this row the "Reset"
                                 action is a sibling of the search field, so a
                                 fluid button stretches to the full panel width
                                 and drops onto its own row — the very defect
                                 the split was meant to remove. The field may
                                 stay fluid (it is the elastic member); the
                                 action may not. -->
                            <Button class="role-permission-search-action" size="small" :fluid="false" :label="store.assets?.language_strings?.view_permissions_reset_button"
                                    @click="store.resetRolePermissionFilters()"
                                    data-testid="role-permission_search_reset"
                            />
                        </div>
                    </div>
                </Fluid>
            </div>

            <DataTable size="small" v-if="store && store.role_permissions && root.assets && root.assets.language_strings && root.assets.language_strings.crud_actions" :value="store.role_permissions.list.data" dataKey="id" class="" stripedRows scrollable>
                <Column field="name"
                        header="Name"
                        class="flex align-items-center"
                >

                    <template #body="prop">
                        <Button class="p-button-tiny p-0 mr-2" text
                                data-testid="role-permission_name_copy"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_copy_slug"
                                @click="useVaah.copy(prop.data.slug)"
                                icon="pi pi-copy"
                                :label="prop.data.name"
                        />



                    </template>
                </Column>

                <Column field="has-permission"
                        header="Has Permission"
                        v-if="store.assets && store.assets.language_strings"
                >

                    <template #body="prop"
                              v-if="store.hasPermission('can-update-roles') || store.hasPermission('can-manage-roles')"
                    >
                        <Button size="small" :label="store.assets.language_strings.view_permissions_yes" severity="success" rounded v-if="prop.data.pivot.is_active === 1" @click="store.changeRolePermission(prop.data)" data-testid="role-permission_status_yes" />

                        <Button size="small" :label="store.assets.language_strings.view_permissions_no" severity="warn" rounded data-testid="role-permission_status_no" v-else @click="store.changeRolePermission(prop.data)" />
                    </template>

                    <template #body="prop"
                              v-else
                    >
                        <Button size="small" :label="store.assets.language_strings.view_permissions_yes" severity="success" rounded v-if="prop.data.pivot.is_active === 1" disabled />

                        <Button size="small" :label="store.assets.language_strings.view_permissions_no" severity="warn" rounded v-else disabled />
                    </template>
                </Column>

                <Column field="is-active"
                        header="Permission Status"
                >

                    <template #body="prop"
                              v-if="(store.hasPermission('can-update-permissions')|| store.hasPermission('can-manage-permissions'))
                               && (store.hasPermission('can-update-roles')|| store.hasPermission('can-manage-roles'))"
                    >
                        <Button size="small" :label="store.assets.language_strings.view_permissions_active" severity="success" rounded v-if="prop.data.is_active === 1" @click="confirmChangeStatus(event, prop.data.id)" data-testid="role-permission_status_active" />

                        <Button size="small" :label="store.assets.language_strings.view_permissions_inactive" data-testid="role-permission_status_inactive" severity="warn" rounded v-else @click="confirmChangeStatus(event, prop.data.id)" />
                    </template>

                    <template #body="prop"
                              v-else
                    >
                        <Button size="small" label="Active" severity="success" rounded v-if="prop.data.is_active === 1" disabled />

                        <Button size="small" label="Inactive" severity="warn" rounded v-else disabled />
                    </template>
                </Column>

                <Column field="actions">
                    <template #body="prop">
                        <Button size="small" rounded outlined @click="openViewModal(), store.active_role_permission = prop.data" icon="pi pi-eye" :label=store.assets.language_strings.view_permissions_text_view v-tooltip.top="store.assets.language_strings.view_permissions_text_view" data-testid="role-permission_view_modal" />
                    </template>
                </Column>
            </DataTable>



            <!--paginator-->
            <Paginator v-if="store && store.role_permissions"
                       v-model:rows="store.role_permissions_query.rows"
                       :totalRecords="store.role_permissions.list.total"
                       @page="store.permissionPaginate($event)"
                       :rowsPerPageOptions="store.rows_per_page"
                       class="bg-white-alpha-0 pt-2"
            />
            <!--/paginator-->
        </Panel>

        <ConfirmDialog group="templating" class="vc-dense"
                       :style="{width: '400px'}"
                       :breakpoints="{'600px': '100vw'}"
        >
            <template #message="slotProps">
                <div class="flex">
                    <i :class="slotProps.message.icon" class="vc-warn-text" style="font-size: 1.5rem"></i>
                    <p class="pl-2">{{slotProps.message.message}}</p>
                </div>
            </template>
        </ConfirmDialog>

        <DynamicDialog  />
    </div>
</template>

<style scoped>

/* UT-108 (D3) — the peer toolbar's sizing: the field takes the room the
   search cluster has, and the list action beside it keeps its own width and
   never shrinks.

   The basis is 160px, not the list screens' 220px: this cluster lives in the
   *narrow* sub-panel (a `col-5` beside the list panel, ~267px wide), and at
   220px the field's basis plus the action's own width no longer fit on one
   line — the action wrapped onto a row of its own. The field still grows to
   fill whatever the cluster has, so it is wider than its basis whenever
   there is room; the basis is only the size the cluster is asked to hold
   before it wraps. */
.role-permission-search-field {
    flex: 1 1 160px;
    min-width: 0;
}

.role-permission-search-action {
    flex: 0 0 auto;
}
</style>
