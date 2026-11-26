<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import { onMounted, ref, watch } from "vue";
import { useRoute } from 'vue-router';
import { useTaxonomyStore } from '../../stores/store-taxonomies'
import { vaah } from "../../vaahvue/pinia/vaah"

import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';
import {useRootStore} from "../../stores/root";
const root = useRootStore();
const store = useTaxonomyStore();
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
    if(!store.item || Object.keys(store.item).length < 1)
    {
        await store.getItem(route.params.id);
    }

    /**
     * Watch if url record id is changed, if changed
     * then fetch the new records from database
     */
    /*watch(route, async (newVal,oldVal) =>
        {
            if(newVal.params && !newVal.params.id
                && newVal.name === 'articles.view')
            {
                store.toList();

            }
            await store.getItem(route.params.id);
        }, { deep: true }
    )*/

});

//--------toggle item menu
const item_menu_state = ref();
const toggleItemMenu = (event) => {
    item_menu_state.value.toggle(event);
};
//--------/toggle item menu

</script>
<template>

    <div class="col-6" >

        <Panel v-if="store && store.item" class="vc-dense">

            <template class="p-1" #header>

                <div class="flex flex-row">

                    <div class="p-panel-title">
                        {{store.item.name}}
                    </div>

                </div>

            </template>

            <template #icons>


                <InputGroup>
                    <Button size="small" class="" :label=" '#' + store.item.id " @click="useVaah.copy(store.item.id)" />

                    <Button size="small" class="" :label="root.assets.language_strings.crud_actions.view_edit" icon="pi pi-pencil" @click="store.toEdit(store.item)" v-if="store.hasPermission('can-update-taxonomies')" />

                    <!--item_menu-->
                    <Button size="small" class="" type="button" @click="toggleItemMenu" data-testid="taxonomies-item-menu" icon="pi pi-angle-down" aria-label="Show actions menu" aria-haspopup="true" v-if="store.hasPermission('can-update-taxonomies') || store.hasPermission('can-manage-taxonomies')" />

                    <Menu ref="item_menu_state"
                          :model="store.item_menu_list"
                          :popup="true" />
                    <!--/item_menu-->

                    <Button aria-label="Back to list" class="p-button-primary"
                            icon="pi pi-times"
                            data-testid="taxonomies-item-to-list"
                            @click="store.toList()"/>

                </InputGroup>



            </template>


            <div v-if="store.item" class="mt-2">

                <Message severity="error"
                         :closable="false"
                         icon="pi pi-trash"
                         v-if="store.item.deleted_at">

                    <div class="flex align-items-center justify-content-between" v-if="root.assets
                               && root.assets.language_strings
                               && root.assets.language_strings.crud_actions"
                    >

                        <div class="">
                            {{root.assets.language_strings.crud_actions.view_deleted}} {{store.item.deleted_at}}
                        </div>

                        <div class="">
                            <Button size="small" :label="root.assets.language_strings.crud_actions.view_restore" class="" data-testid="taxonomies-item-restore" @click="store.itemAction('restore')">
                            </Button>
                        </div>

                    </div>

                </Message>

                <div class="p-datatable p-component taxonomies-item-stripes">
                <table class="p-datatable-table">
                    <tbody class="p-datatable-tbody">
                    <template v-for="(value, column) in store.item ">

                        <template v-if="column === 'created_by'
                        || column === 'type'
                        || column === 'parent'
                        || column === 'updated_by'">
                        </template>

                        <template v-else-if="column === 'id' || column === 'uuid' || column === 'slug'">
                            <VhViewRow :label="column"
                                       :value="value"
                                       :can_copy="true"
                            />
                        </template>

                        <template v-else-if="(column === 'created_by_user' || column === 'updated_by_user'  || column === 'deleted_by_user') && (typeof value === 'object' && value !== null)">
                            <VhViewRow :label="column"
                                       :value="value"
                                       type="user"
                            />
                        </template>

                        <template v-else-if="column === 'parent_id'">
                        <VhViewRow :label="store.item.parent?'parent':''"
                                   :value="store.item.parent && store.item.parent.name ? store.item.parent.name : ''"
                            />
                        </template>

                        <template v-else-if="column === 'vh_taxonomy_type_id'">
                            <VhViewRow label="Type"
                                       :value="store.item.type && store.item.type.name ?  store.item.type.name : ''"
                            />
                        </template>

                        <template v-else-if="column === 'is_active'">
                            <VhViewRow :label="column"
                                       :value="value"
                                       type="yes-no"
                            />
                        </template>

                        <template v-else-if="column === 'meta'">
                            <tr>
                                <td><b>Meta</b></td>
                                <td v-if="value" >
                                    <Button size="small" icon="pi pi-eye" label="view" class="p-button-outlined p-button-secondary p-button-rounded" @click="store.openModal(value)" data-testid="register-open_meta_modal" />
                                </td>
                            </tr>

                            <Dialog header="Meta"
                                    v-model:visible="store.display_meta_modal"
                                    :breakpoints="{'960px': '75vw', '640px': '90vw'}"
                                    :style="{width: '50vw'}" :modal="true"
                            >
                                <p class="m-0" v-html="'<pre>'+store.meta_content+'<pre>'"></p>
                            </Dialog>

                        </template>

                        <template v-else>
                            <VhViewRow :label="column"
                                       :value="value"
                                       />
                        </template>


                    </template>
                    </tbody>

                </table>

                </div>
            </div>
        </Panel>

    </div>

</template>

<style scoped>
/* M5-T4 (F19) — F11 R3.6 explicit local replacement for the v3 striped-row
   style class (the one R3.6 replaces with the `stripedRows` prop) on this
   hand-rolled view table.

   The table is plain DOM (no <DataTable> component), so the `stripedRows`
   prop has no host to attach to, and the v4 engine's striped rule — which
   targets a row class the DataTable component emits on its own rows — cannot
   match hand-rolled rows: the v3 class name on the wrapper matched nothing
   here and the view table rendered flat.

   The v3 `tr:nth-child(odd)` selector is therefore kept as a local style, and
   the background is bound to the v4 `datatable.row.striped.background` token —
   the OpenVue theme emits it as `--p-datatable-row-striped-background` (Nide:
   surface.50 light / a surface.800 mix dark), scheme-aware via the
   `.app-dark` darkModeSelector — the same value the engine styles
   `stripedRows` DataTable rows with, so the stripe is identical to a
   `stripedRows` DataTable in both light and dark (D3 visual parity).

   Reference implementation: `pages/modules/Item.vue` (M6-T2 / F21). */
.taxonomies-item-stripes :deep(tr:nth-child(odd)) {
    background: var(--p-datatable-row-striped-background);
}

/* M5-T4 (F19) — the deleted-record banner is body copy, so its text sits on
   the 13px step of the type scale (12 · 13 · 14 · 16 · 20 · 24 at the 14px
   root). The v4 Message renders its text at the engine's rem default, which
   measures 12.25px at this root — off-scale by 0.25px. The app already fixes
   this per screen rather than in the global token layer: see the identical
   rule in `pages/dashboard/Dashboard.vue`. */
:deep(.p-message .p-message-text) {
    font-size: 13px;
    line-height: 1.5;
}
</style>
