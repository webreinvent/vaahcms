<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import { vaah } from '../../vaahvue/pinia/vaah'
import { useUserStore } from '../../stores/store-users'
import { useRootStore } from "../../stores/root";
import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import {onMounted, ref, watch} from "vue";
import {useRoute} from "vue-router";
import Dialog from 'openvue/dialog';

const root = useRootStore();
const store = useUserStore();
const useVaah = vaah();
const route = useRoute();

onMounted(async () => {

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
     * Fetch user roles from the database
     */
    if (store.item && !store.user_roles) {
        await store.getUserRoles();
    }

    /**
    * Fetch user roles menu items
    */

    if (store.assets && store.assets.language_strings)
    {
        await store.getUserRolesMenuItems();
    }

});

//--------toggle item menu--------//
const user_roles_menu_state = ref();

const toggleItemMenu = (event) => {
    user_roles_menu_state.value.toggle(event);
};
//--------toggle item menu--------//

watch(
    () => store.assets,
    async () => {
        if ( store.assets.language_strings)
        {
            await store.getUserRolesMenuItems();
        }

    }
)


</script>
<template>
    <div class="col-5" >
        <Panel v-if="store.item" class="vc-dense">
            <template class="p-1" #header>
                <div class="flex flex-row">
                    <div class="font-semibold vc-text-16">
                        {{ store.item.name }}
                    </div>
                </div>
            </template>

            <template #icons>
                <InputGroup>
                    <Button size="small" class="" :label=" '#' + store.item.id " @click="useVaah.copy(store.item.id)" data-testid="user-role_id" />

                    <!--item_menu-->
                    <Button size="small" class="" icon="pi pi-angle-down" aria-label="Show actions menu" aria-haspopup="true" @click="toggleItemMenu" data-testid="user-role_menu" v-if="store.hasPermission('can-update-users') || store.hasPermission('can-manage-users')" />

                    <Menu ref="user_roles_menu_state"
                          :model="store.user_roles_menu"
                          :popup="true"
                    />
                    <!--/item_menu-->

                    <Button size="small" class="" icon="pi pi-times" aria-label="Back to list" data-testid="user-role_view" @click="store.toList()" />
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
                    <div class="user-role-search flex flex-wrap items-center gap-2">
                        <InputGroup class="user-role-search-field">
                             <InputGroupAddon>
                                <i class="pi pi-search" />
                             </InputGroupAddon>
                             <InputText aria-label="Search roles" size="small" class="w-full" :placeholder="store.assets?.language_strings?.view_role_placeholder_search" type="text" v-model="store.user_roles_query.q" @keyup.enter="store.delayedUserRolesSearch()" @keyup.enter.native="store.delayedUserRolesSearch()" @keyup.13="store.delayedUserRolesSearch()" />
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
                        <Button size="small" :fluid="false" class="user-role-search-action" :label="store.assets?.language_strings?.view_role_reset_button" data-testid="user-role_reset" @click="store.resetUserRolesFilters()" />
                    </div>
                </div>
            </Fluid>

            <div>
                <!-- M6-T5 — the v3 `p-datatable-striped` class was dead in
                     the v4 pipeline (no rule is emitted for it). The table
                     below is a real v4 `<DataTable>` and already carries
                     the `stripedRows` prop, so the striping is delivered
                     by the engine; the dead class is simply dropped. -->
                <div class="p-datatable p-component">
                    <div v-if="store.user_roles
                               && root.assets
                               && root.assets.language_strings
                               && root.assets.language_strings.crud_actions"
                    >
                        <DataTable size="small" :value="store.user_roles.list.data" dataKey="id" class="" stripedRows scrollable>
                            <Column field="role"
                                    header="Roles"
                                    class="flex align-items-center"
                            >
                                <template #body="prop">
                                    {{ prop.data.name }}

                                    <Button aria-label="Copy role slug" class="p-button-tiny p-button-text"
                                            data-testid="taxonomies-table-to-edit"
                                            v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_copy_slug"
                                            @click="useVaah.copy(prop.data.slug)"
                                            icon="pi pi-copy"
                                    />
                                </template>
                            </Column>

                            <Column field="role"
                                    header="Has Role"
                                    v-if="store.assets && store.assets.language_strings">
                                <template #body="prop" v-if="store.hasPermission('can-update-users') || store.hasPermission('can-manage-users')">
                                    <Button size="small" v-if="prop.data.pivot.is_active === 1" class="p-button-success p-button-rounded" :label="store.assets.language_strings.view_role_yes" data-testid="user-role_status_yes" @click="store.changeUserRole(prop.data,route.params.id)" />

                                    <Button size="small" v-else class="p-button-danger p-button-rounded" :label="store.assets.language_strings.view_role_no" data-testid="user-role_status_no" @click="store.changeUserRole(prop.data,route.params.id)" />
                                </template>

                                <template #body="prop" v-else>
                                    <Button size="small" v-if="prop.data.pivot.is_active === 1" class="p-button-success p-button-rounded" :label="store.assets.language_strings.view_role_yes" disabled />

                                    <Button size="small" v-else class="p-button-danger p-button-rounded" :label="store.assets.language_strings.view_role_no" disabled />
                                </template>
                            </Column>

                            <Column field="view"
                                    v-if="store.assets && store.assets.language_strings"
                                    header="View"
                            >
                                <template #body="prop">
                                    <Button size="small" class=" p-button-rounded p-button-outlined" v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_view" @click="store.showModal(prop.data)" data-testid="user-role_details_view" icon="pi pi-eye" :label="store.assets.language_strings.view_role_text_view" />
                                </template>
                            </Column>
                        </DataTable>

                        <!--paginator-->
                        <Paginator v-model:first="store.rolesFirstElement"
                                   :rows="store.user_roles_query.rows"
                                   :totalRecords="store.user_roles.list.total"
                                   @page="store.userRolesPaginate($event)"
                                   :rowsPerPageOptions="store.rows_per_page"
                                   class="bg-white-alpha-0 pt-2"
                        >
                        </Paginator>
                        <!--/paginator-->
                    </div>

                </div>
            </div>
        </Panel>

        <Dialog header="Details"
                v-model:visible="store.displayModal"
                :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}"
                :modal="true"
        >
            <div v-for="(item,index) in store.modalData" :key="index">
                <span> {{ index }} </span> : {{ item }}

                <Divider />
            </div>
        </Dialog>
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
.user-role-search-field {
    flex: 1 1 160px;
    min-width: 0;
}

.user-role-search-action {
    flex: 0 0 auto;
}
</style>
