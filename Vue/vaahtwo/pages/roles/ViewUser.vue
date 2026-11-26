<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import { h, onMounted, ref } from "vue";
import { useRoute } from 'vue-router';

import { useRoleStore } from '../../stores/store-roles';
import { vaah } from '../../vaahvue/pinia/vaah';
import { useDialog } from "openvue/usedialog";
import RoleUserDetailsView from "./components/RoleUserDetailsView.vue";

const store = useRoleStore();
const route = useRoute();
const useVaah = vaah();

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
     * Fetch item users from the database
     */
    if (store.item && !store.role_users) {
        await store.getItemUsers();
    }

    /**
     * Fetch user menu item from store
     */
    await store.getRoleUserMenuItems();
});

//--------toggle item menu--------//
const uer_items_menu = ref();

const toggleItemMenu = (event) => {
    uer_items_menu.value.toggle(event);
};
//--------toggle item menu--------//


//--------toggle dynamic modal--------//
const dialog = useDialog();

const openDetailsViewModal = () => {
    const dialogRef = dialog.open(RoleUserDetailsView, {
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

                    <Button size="small" class="" :label=" '#' + store.item.id" @click="useVaah.copy(store.item.id)" data-testid="role-user_id" />

                    <!--/item_menu-->
                    <template v-if="store.hasPermission('can-update-roles')
                                    || store.hasPermission('can-manage-roles')"
                              class="control"
                    >
                        <Button size="small" class="" icon="pi pi-angle-down" aria-label="Show actions menu" type="button" aria-haspopup="true" data-testid="role-user_menu" @click="toggleItemMenu" />

                        <Menu ref="uer_items_menu"
                              :model="store.role_user_menu_items"
                              :popup="true"
                        />
                    </template>
                    <!--/item_menu-->

                    <Button size="small" class="" icon="pi pi-times" aria-label="Back to list" data-testid="role-user_list" @click="store.toList()" />
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
                    <div class="role-user-search flex flex-wrap items-center gap-2">
                        <InputGroup class="role-user-search-field">
                             <InputGroupAddon>
                                <i class="pi pi-search" />
                             </InputGroupAddon>
                             <InputText aria-label="Search users" size="small" v-model="store.role_users_query.q" @keyup.enter="store.delayedRoleUsersSearch()" @keyup.enter.native="store.delayedRoleUsersSearch()" @keyup.13="store.delayedRoleUsersSearch()" :placeholder="store.assets?.language_strings?.view_users_placeholder_search" type="text" data-testid="role-user_search" class="w-full" />
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
                        <Button size="small" :fluid="false" class="role-user-search-action" data-testid="role-user_search_reset" :label="store.assets?.language_strings?.view_users_reset_button" @click="store.resetRoleUserFilters()" />
                    </div>
                </div>
            </Fluid>


            <DataTable size="small" v-if="store && store.role_users" :value="store.role_users.list.data" dataKey="id" class="" stripedRows scrollable>
                <Column field="name"
                        header="Name"
                >
                    <template #body="prop">
                        {{ prop.data.name }}
                    </template>
                </Column>

                <Column field="email"
                        header="Email"
                >
                    <template #body="prop">
                        {{ prop.data.email }}
                    </template>
                </Column>

                <Column field="has-role"
                        header="Has Role"
                        v-if="store.assets && store.assets.language_strings"
                >
                    <template #body="prop"
                              v-if="store.hasPermission('can-update-roles')||
                                    store.hasPermission('can-manage-roles')"
                    >
                        <Button size="small" :label="store.assets.language_strings.view_users_yes" severity="success" rounded v-if="prop.data.pivot.is_active === 1" @click="store.changeUserRole(prop.data)" data-testid="role-user_status_yes" />

                        <Button size="small" :label="store.assets.language_strings.view_users_no" severity="warn" rounded data-testid="role-user_status_no" v-else @click="store.changeUserRole(prop.data)" />
                    </template>

                    <template #body="prop"
                              v-else
                    >
                        <Button size="small" :label="store.assets.language_strings.view_users_yes" severity="success" rounded v-if="prop.data.pivot.is_active === 1" disabled />

                        <Button size="small" :label="store.assets.language_strings.view_users_no" severity="warn" rounded v-else disabled />
                    </template>
                </Column>

                <Column field="actions">
                    <template #body="prop">
                        <Button size="small" rounded outlined @click="openDetailsViewModal(), store.active_role_user = prop.data" icon="pi pi-eye" :label=store.assets.language_strings.view_users_text_view data-testid="role-user_view_details" />
                    </template>
                </Column>
            </DataTable>
            <!--paginator-->
            <Paginator v-if="store && store.role_users"
                       v-model:rows="store.role_users_query.rows"
                       :totalRecords="store.role_users.list.total"
                       @page="store.userPaginate($event)"
                       :rowsPerPageOptions="store.rows_per_page"
                       class="bg-white-alpha-0 pt-2"
            />
            <!--/paginator-->
        </Panel>

        <DynamicDialog  />
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
.role-user-search-field {
    flex: 1 1 160px;
    min-width: 0;
}

.role-user-search-action {
    flex: 0 0 auto;
}
</style>
