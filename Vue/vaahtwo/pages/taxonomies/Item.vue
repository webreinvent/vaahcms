<script setup>
import { onMounted, ref, watch } from "vue";
import { useRoute } from 'vue-router';
import { useTaxonomyStore } from '../../stores/store-taxonomies'
import { vaah } from "../../vaahvue/pinia/vaah"

import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';
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

        <Panel v-if="store && store.item" class="is-small">

            <template class="p-1" #header>

                <div class="flex flex-row">

                    <div class="p-panel-title">
                        {{store.item.name}}
                    </div>

                </div>

            </template>

            <template #icons>


                <div class="p-inputgroup">
                    <Button class="p-button-sm"
                            :label=" '#' + store.item.id "
                            @click="useVaah.copy(store.item.id)"
                    />

                    <Button class="p-button-sm"
                            label="Edit"
                            icon="pi pi-pencil"
                            @click="store.toEdit(store.item)"
                            v-if="store.hasPermission('can-update-taxonomies')"
                    />

                    <!--item_menu-->
                    <Button class="p-button-sm"
                            type="button"
                            @click="toggleItemMenu"
                            data-testid="taxonomies-item-menu"
                            icon="pi pi-angle-down"
                            aria-haspopup="true"
                            v-if="store.hasPermission('can-update-taxonomies') || store.hasPermission('can-manage-taxonomies')"
                    />

                    <Menu ref="item_menu_state"
                          :model="store.item_menu_list"
                          :popup="true" />
                    <!--/item_menu-->

                    <Button class="p-button-primary"
                            icon="pi pi-times"
                            data-testid="taxonomies-item-to-list"
                            @click="store.toList()"/>

                </div>



            </template>


            <div v-if="store.item" class="mt-2">

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
                            <Button label="Restore"
                                    class="p-button-sm"
                                    data-testid="taxonomies-item-restore"
                                    @click="store.itemAction('restore')">
                            </Button>
                        </div>

                    </div>

                </Message>

                <div class="p-datatable p-component p-datatable-responsive-scroll p-datatable-striped p-datatable-sm">
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
                                    <Button icon="pi pi-eye"
                                            label="view"
                                            class="p-button-outlined p-button-secondary p-button-rounded p-button-sm"
                                            @click="store.openModal(value)"
                                            data-testid="register-open_meta_modal"
                                    />
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
