<script setup>
import {onMounted, ref, watch} from "vue";
import {useRoute} from 'vue-router';
import {vaah} from '../../vaahvue/pinia/vaah';
import { useMediaStore } from '../../stores/store-media';
import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';

const store = useMediaStore();
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

    if(route.params && route.params.id) {
        await store.getItem(route.params.id);
    }

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
                    <Button :label=" '#' + store.item.id "
                            class="p-button-sm"
                            @click="useVaah.copy(store.item.id)"
                            data-testid="media-item-id"
                    />

                    <Button label="Edit"
                            class="p-button-sm"
                            @click="store.toEdit(store.item)"
                            data-testid="media-item-to-edit"
                            icon="pi pi-pencil"
                            v-if="store.hasPermission('can-update-media')"
                    />

                    <!--item_menu-->
                    <Button class="p-button-sm"
                            @click="toggleItemMenu"
                            data-testid="media-item-menu"
                            icon="pi pi-angle-down"
                            aria-haspopup="true"
                            v-if="store.hasPermission('can-update-media') || store.hasPermission('can-manage-media')"
                    />

                    <Menu ref="item_menu_state"
                          :model="store.item_menu_list"
                          :popup="true"
                    />
                    <!--/item_menu-->

                    <Button class="p-button-sm"
                            icon="pi pi-times"
                            data-testid="media-item-to-list"
                            @click="store.toList()"
                    />
                </div>
            </template>

            <div v-if="store.item">
                <Message severity="error"
                         class="p-container-message"
                         :closable="false"
                         icon="pi pi-trash"
                         v-if="store.item.deleted_at"
                >
                    <div class="flex align-items-center justify-content-between">

                        <div class="">
                            Deleted {{store.item.deleted_at}}
                        </div>

                        <div class="">
                            <Button label="Restore"
                                    class="p-button-sm"
                                    data-testid="media-item-restore"
                                    @click="store.itemAction('restore')"
                            />
                        </div>
                    </div>
                </Message>

                <div class="p-datatable p-component p-datatable-responsive-scroll p-datatable-striped p-datatable-sm">
                    <table class="p-datatable-table">
                        <tbody class="p-datatable-tbody">
                            <template v-for="(value, column) in store.item ">

                                <template v-if="column === 'created_by'
                                || column === 'updated_by'
                                || column === 'size_for_humans'
                                || column === 'thumbnail_size_for_humans'
                                || column === 'download_url_full'">
                                </template>

                                <template v-else-if="column === 'id' || column === 'uuid'">
                                    <VhViewRow :label="column"
                                               :value="value"
                                               :can_copy="true"
                                    />
                                </template>

                                <template v-else-if="(column === 'created_by_user' ||
                                column === 'updated_by_user'  || column === 'deleted_by_user')
                                                    && (typeof value === 'object' && value !== null)">
                                    <VhViewRow :label="column"
                                               :value="value"
                                               type="user"
                                    />
                                </template>

                                <template v-else-if="(column === 'url'
                                    || column === 'url_thumbnail') && store.item.type === 'image'">
                                    <tr>
                                        <td :style="{width: '200px'}">
                                            <b>{{vaah().toLabel(column.replace("url", store.item.type))}}</b>
                                        </td>
                                        <td> <img v-if="store.item[column]"
                                                  :src="store.item[column]"
                                                  :alt="store.item.name"
                                                  width="45"
                                                  height="45"
                                                  style="border-radius: 50%;height: 45px"
                                        /></td>
                                        <td v-if="store.item[column]">
                                            <Button icon="pi pi-external-link"
                                                    @click="store.openImage(store.item[column])"
                                                    class="p-button-text p-button-sm"/>
                                        </td>
                                    </tr>

                                </template>

                                <template v-else-if="column === 'is_active' ||
                                column === 'is_downloadable' || column === 'download_requires_login'">
                                    <VhViewRow :label="column"
                                               :value="value"
                                               type="yes-no"
                                    />
                                </template>

                                <template v-else-if="column === 'size'
                                 || column === 'thumbnail_size'">
                                    <tr>
                                        <td><b>{{ vaah().toLabel(column) }}</b></td>
                                        <td colspan="2">
                                            <Tag severity="primary">{{ store.item[column+'_for_humans'] }}</Tag>
                                        </td>
                                    </tr>
                                </template>
                                <template v-else-if="column === 'path'">
                                    <tr>
                                        <td><b>{{ vaah().toLabel(column) }}</b></td>
                                        <td style="word-break: break-all;">{{ value }}</td>
                                    </tr>
                                </template>

                                <template v-else-if="store.item.type !== 'image'
                                && (column === 'url' ||
                                column === 'url_thumbnail') ">
                                    <tr>
                                        <td><b>{{ vaah().toLabel(column) }}</b></td>
                                        <td style="word-break: break-all;">{{ value }}</td>
                                        <td v-if="value">
                                            <Button icon="pi pi-external-link"
                                                    @click="store.openImage(value)"
                                                    class="p-button-text p-button-sm"/>
                                        </td>
                                    </tr>
                                </template>

                                <template v-else-if="column === 'download_url' ">
                                    <tr>
                                        <td><b>{{ vaah().toLabel(column) }}</b></td>
                                        <td style="word-break: break-all;">{{store.assets.download_url}}{{ value }}</td>
                                        <td v-if="store.item.download_url_full">
                                            <Button icon="pi pi-external-link"
                                                    @click="store.openImage(store.item.download_url_full)"
                                                    class="p-button-text p-button-sm"/>
                                        </td>
                                    </tr>
                                </template>

                                <template v-else-if="column === 'meta'">
                                    <tr>
                                        <td><b>Meta</b></td>
                                        <td  v-if="value">
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
