<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });

import { onMounted, ref } from "vue";
import { usePermissionStore } from "../../stores/store-permissions";
import { useDialog } from 'openvue/usedialog';
import RoleDetailsView from './components/RoleDetasilsView.vue'
import { useRoute } from "vue-router";
import { useRootStore } from "../../stores/root";
import { vaah } from "../../vaahvue/pinia/vaah";

const store = usePermissionStore();
const root = useRootStore();
const route = useRoute();
const useVaah = vaah();

onMounted( async () => {
    /**
     * If record id is not set in url then
     * redirect user to list view
     */
    if (route.params && !route.params.id) {
        store.toList();
        return false;
    }

    /**
     * Fetch the item from the database
     */
    if (route.params && route.params.id) {
        await store.getItem(route.params.id);
    }

    /**
     * Fetch the record from the database
     */
    if (store.item && !store.permission_roles) {
        await store.getItemRoles();
    }

    /**
     * Fetch the permissions from the database
     */
    await root.getPermission();

    /**
     * Fetch the role menu items
     */
    await store.getRoleMenu();
});


//--------toggle item menu--------//
const role_menu_items = ref();

const toggleItemMenu = (event) => {
    role_menu_items.value.toggle(event);
};
//--------toggle item menu--------//


//--------toggle dynamic modal--------//
const dialog = useDialog();

const openViewModal = () => {
    const dialogRef = dialog.open(RoleDetailsView, {
        props: {
            header: store.assets.language_strings.details_dialogue,
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

</script>

<template>
    <div class="col-5">
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

                    <Button size="small" class="" :label=" '#' + store.item.id" data-testid="permission-role_id" @click="useVaah.copy(store.item.id)" />

                    <!--/item_menu-->
                    <template v-if="store.hasPermission('can-update-permissions')
                                    || store.hasPermission('can-manage-permissions')"
                              class="control"
                    >
                        <Button size="small" class="" icon="pi pi-angle-down" aria-label="Show actions menu" type="button" aria-haspopup="true" data-testid="permission-role_menu" @click="toggleItemMenu" />

                        <Menu ref="role_menu_items"
                              :model="store.roles_menu_items"
                              :popup="true"
                        />
                    </template>
                    <!--/item_menu-->

                    <Button size="small" class="" icon="pi pi-times" aria-label="Back to list" data-testid="permission-role_list" @click="store.toList()" />
                </InputGroup>
            </template>



            <Fluid class="grid mt-1 mb-2">
                <div class="col-12">
                    <!-- UT-108 (D3) — the search field and the "Reset" button
                         were welded into one `InputGroup`, so the row read as
                         a single oversized input with a button stuck to its
                         right edge — the defect the UT-108 cross-screen
                         probe found on the list toolbars. The field and its
                         search glyph are one control and stay together;
                         "Reset" acts on the *list*, not on the field, so it is
                         a button of its own beside it (the peer contract). -->
                    <div class="permission-role-search flex flex-wrap items-center gap-2">
                        <InputGroup class="permission-role-search-field">
                            <InputGroupAddon>
                                <i class="pi pi-search" />
                            </InputGroupAddon>
                            <InputText aria-label="Search roles" size="small" class="w-full" :placeholder="store.assets?.language_strings?.view_roles_placeholder_search" data-testid="permission-role_search" v-model="store.permission_roles_query.q" @keyup.enter="store.delayedItemUsersSearch()" @keyup.enter.native="store.delayedItemUsersSearch()" @keyup.13="store.delayedItemUsersSearch()" />
                        </InputGroup>

                        <!-- UT-108 — `:fluid="false"` is load-bearing here. The
                             v3 `<Fluid class="grid">` wrapper is a v4 `<Fluid>`
                             component, which *provides* a fluid context: every
                             Button below it (at any depth) is rendered
                             `p-button-fluid`, i.e. `width: 100%`. Inside this
                             row the "Reset" action is a sibling of the search
                             field, so a fluid button stretches to the full
                             panel width and drops onto its own row — the very
                             defect the split was meant to remove. The field
                             may stay fluid (it is the elastic member); the
                             action may not. -->
                        <Button size="small" :fluid="false" class="permission-role-search-action" :label="store.assets?.language_strings?.view_roles_reset_button" data-testid="permission-role_reset" @click="store.resetPermissionRolesQuery()" />
                    </div>
                </div>
            </Fluid>
            <DataTable size="small" v-if="store && store.permission_roles" :value="store.permission_roles.list.data" dataKey="id" class="" stripedRows scrollable>
                <Column field="role"
                        header="Role"
                        class="flex align-items-center"
                >

                    <template #body="prop" >

                        {{ prop.data.name }}

                        <Button aria-label="Copy role id" class="p-button-tiny" text
                                data-testid="permissions-role_id"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_copy_slug"
                                @click="useVaah.copy(prop.data.slug)"
                                icon="pi pi-copy"
                        />

                    </template>
                </Column>

                <Column field="has-permission"
                        header="Has Permission"
                        v-if="store.assets && store.assets.language_strings"
                >

                    <template #body="prop"
                              v-if="store.hasPermission('can-update-permissions') || store.hasPermission('can-manage-permissions')"
                    >
                        <Button size="small" :label="store.assets.language_strings.view_roles_yes" severity="success" rounded v-if="prop.data.pivot.is_active === 1" data-testid="permission-role_status_yes" @click="store.changePermission(prop.data)" />

                        <Button size="small" :label="store.assets.language_strings.view_roles_no" severity="warn" rounded v-else @click="store.changePermission(prop.data)" data-testid="permission-role_status_no" />
                    </template>

                    <template #body="prop"
                              v-else

                    >
                        <Button size="small" :label="store.assets.language_strings.view_roles_yes" severity="success" rounded v-if="prop.data.pivot.is_active === 1" disabled />

                        <Button size="small" :label="store.assets.language_strings.view_roles_no" severity="warn" rounded disabled v-else />
                    </template>
                </Column>

                <Column field="actions">
                    <template #body="prop">
                        <Button size="small" rounded @click="openViewModal(), store.active_permission_role = prop.data" icon="pi pi-eye" data-testid="permission-role_view_details" :label=store.assets.language_strings.view_roles_text_view />
                    </template>
                </Column>
            </DataTable>


            <!--paginator-->
            <Paginator v-if="store && store.permission_roles"
                       v-model:first="store.rolesFirstElement"
                       :rows="store.permission_roles_query.rows"
                       :totalRecords="store.permission_roles.list.total"
                       @page="store.rolePaginate($event)"
                       :rowsPerPageOptions="store.rows_per_page"
                       class="bg-white-alpha-0 pt-2"
            />
            <!--/paginator-->
        </Panel>

        <DynamicDialog />
    </div>
</template>


<style scoped>

/* UT-108 (D3) — the peer toolbar's sizing: the field takes the room the
   search cluster has, and the list action beside it keeps its own width and
   never shrinks.

   The basis is 160px, not the list screens' 220px: this cluster lives in the
   *narrow* sub-panel (a `col-5` beside the list panel), and at 220px the
   field's basis plus the action's own width no longer fit on one line — the
   action wrapped onto a row of its own. The field still grows to fill
   whatever the cluster has, so it is wider than its basis whenever there is
   room; the basis is only the size the cluster is asked to hold before it
   wraps. */
.permission-role-search-field {
    flex: 1 1 160px;
    min-width: 0;
}

.permission-role-search-action {
    flex: 0 0 auto;
}
</style>
