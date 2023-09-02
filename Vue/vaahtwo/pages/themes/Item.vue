<script setup>
import {onMounted, ref, watch} from "vue";
import {useRoute} from 'vue-router';

import { useThemeStore } from '../../stores/store-themes'

import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';
import {vaah} from "../../vaahvue/pinia/vaah";
const store = useThemeStore();
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

            <template #header>
                <div class="flex justify-content-between align-items-center w-full">
                    <h5 class="white-space-nowrap font-semibold text-lg pt-2">{{ store.item.name}}</h5>
                    <div class="p-inputgroup justify-content-end w-6 flex">
                        <h5 class="white-space-nowrap font-semibold text-lg pt-2 pr-3">#{{ store.item.id }}</h5>
                        <Button class="p-button-outlined" @click="store.closeInstallTheme()" icon="pi pi-times"></Button>
                    </div>
                </div>
            </template>

            <template #icons>

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
                            <Button label="Restore"
                                    class="p-button-sm"
                                    data-testid="themes-item-restore"
                                    @click="store.itemAction('restore')">
                            </Button>
                        </div>

                    </div>

                </Message>

                <div class="p-datatable p-component p-datatable-responsive-scroll p-datatable-striped p-datatable-sm">
                <table class="p-datatable-table">
                    <tbody class="p-datatable-tbody">
                    <template v-for="(value, column) in store.item ">
                        <template v-if="column === 'created_by' || column === 'updated_by'"></template>
                        <template v-else-if="column === 'author_website'">
                            <tr>
                                <td><b>{{ vaah().toLabel(column) }}</b></td>
                                <td style="word-break: break-all;">{{ value }}</td>
                                <td>
                                    <Button icon="pi pi-external-link"
                                        @click="store.openWebsite(value)"
                                        class="p-button-text p-button-sm"
                                    />
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
                                            || column === 'is_update_available'
                                            || column === 'is_assets_published'
                                            || column === 'is_migratable'
                                            || column === 'is_default'
                                            || column === 'is_sample_data_available'
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
