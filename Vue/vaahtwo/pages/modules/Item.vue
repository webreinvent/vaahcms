<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import {onMounted, ref, watch} from "vue";
import {useRoute} from 'vue-router';
import { vaah } from "../../vaahvue/pinia/vaah";
import { useModuleStore } from '../../stores/store-modules'

import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';
const store = useModuleStore();
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

        <Panel v-if="store && store.item">

            <template class="p-1" #header>
                <div class="flex flex-row w-full">
                    <div class="p-panel-title font-semibold vc-text-16 flex align-items-center">
                        {{ store.item.name }}
                    </div>
                </div>
            </template>

            <template #icons>
                <InputGroup>
                    <Button size="small" class="" :label=" '#' + store.item.id" @click="useVaah.copy(store.item.id)" />

                    <Button size="small" class="" icon="pi pi-times" aria-label="Back to list" data-testid="modules-item-to-list" @click="store.toList()" />
                </InputGroup>
            </template>


            <div v-if="store.item">

                <Message severity="error"
                         class="p-container-message"
                         :closable="false"
                         icon="pi pi-trash"
                         v-if="store.item.deleted_at">

                    <div class="flex align-items-center justify-content-between">

                        <div class="">
                            Deleted {{store.item.deleted_at}}
                        </div>

                        <div class="">
                            <Button size="small" label="Restore" class="" data-testid="modules-item-restore" @click="store.itemAction('restore')">
                            </Button>
                        </div>

                    </div>

                </Message>

                <div class="p-datatable p-component modules-item-stripes">
                <table class="p-datatable-table w-full">
                    <tbody class="p-datatable-tbody">
                    <template v-for="(value, column) in store.item ">

                        <template v-if="column === 'created_by' || column === 'updated_by'">
                        </template>

                        <template v-else-if="column === 'author_website'">
                            <tr>
                                <td><b>{{ vaah().toLabel(column) }}</b></td>
                                <td style="word-break: break-all;">{{ value }}</td>
                                <td><Button size="small" icon="pi pi-external-link" aria-label="Open in a new tab" @click="store.openWebsite(value)" class="p-button-text"/>
                                </td>
                            </tr>
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

                        <template v-else-if="column === 'is_active'
                                            || column === 'is_assets_published'
                                            || column === 'is_update_available'
                                            || column === 'is_sample_data_available'
                                            || column === 'is_migratable'
                            ">
                            <VhViewRow :label="column"
                                       :value="value"
                                       type="yes-no"
                            />
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
/* M6-T2 (F21) — F11 R3.6 explicit local replacement for the v3 striped-row
   style class (the one R3.6 replaces with the `stripedRows` prop) on this
   hand-rolled view table. The table is plain DOM (no <DataTable>
   component), so the `stripedRows` prop has no host to attach to, and the
   v4 engine's striped rule — which targets a row class the DataTable
   component emits on its own rows — cannot match hand-rolled rows. The v3
   `tr:nth-child(odd)` selector is therefore kept as a local style, and the
   background is bound to the v4 `datatable.row.striped.background` token —
   the OpenVue theme emits it as `--p-datatable-row-striped-background`
   (Nide: surface.50 light / a surface.800 mix dark), scheme-aware via the
   `.app-dark` darkModeSelector — the same value the engine styles
   `stripedRows` DataTable rows with, so the stripe is identical to a
   `stripedRows` DataTable in both light and dark (D3 visual parity). */
.modules-item-stripes :deep(tr:nth-child(odd)) {
    background: var(--p-datatable-row-striped-background);
}
</style>
