<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

import {useModuleStore} from '../../stores/store-modules';

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";

const store = useModuleStore();
const route = useRoute();

import { useConfirm } from "primevue/useconfirm";
const confirm = useConfirm();

onMounted(async () => {
    /**
     * call onLoad action when List view loads
     */
    await store.onLoad(route);
    /**
     * watch routes to update view, column width
     * and get new item when routes get changed
     */
    await store.watchRoutes(route);
    /**
     * watch states like `query.filter` to
     * call specific actions if a state gets
     * changed
     */
    await store.watchStates();
    /**
     * fetch assets required for the crud
     * operation
     */
    await store.getAssets();
    /**
     * fetch list of records
     */
    await store.getModules();
});
</script>
<template>
    <div class="col-6" >
        <div v-if="store.modules.list && store.modules.list.data">
            <Card class="is-small">
                <template #header>
                    <div class="flex justify-content-between align-items-center mt-2">
                        <h5 class="white-space-nowrap font-semibold text-base">Install Modules</h5>
                        <div class="p-inputgroup justify-content-end w-6">
                                <span class="p-input-icon-left">
                                    <i class="text-xs pi pi-search" />
                                    <InputText placeholder="Search"
                                               class="w-full pl-5 p-inputtext-sm"
                                               type="search"
                                               icon="search"
                                               v-model="store.modules.query_string.q"
                                               @input="store.delayedSearch"
                                               @keyup.enter.prevent="store.delayedSearch">
                                               data-testid="modules-install-filter_input"
                                    </InputText>
                                </span>
                            <Button class="p-button-sm"
                                    data-testid="modules-install-filter_button"
                                    @click="store.closeInstallModule()"
                                    icon="pi pi-times"></Button>
                        </div>
                    </div>
                </template>
                <template #content>
                    <div class="flex flex-wrap mb-2">
                        <div class="col-6" v-for="item in store.modules.list.data">
                            <Card :pt="{ footer: 'mb-2'}">
                                <template #header>
                                    <img :src="item.thumbnail" class="w-full"/>
                                </template>
                                <template #content>
                                    <h5 class="text-lg font-semibold mb-1">{{item.title}}</h5>
                                    <p class="mb-3 text-sm">{{item.excerpt}}</p>
                                    <Tag class="mr-2 mb-2 bg-blue-50 text-blue-600 font-semibold">Name: {{item.title}}</Tag>
                                    <Tag class="mr-2 mb-2 bg-blue-50 text-blue-600 font-semibold">Version: {{item.version}}</Tag>
                                    <Tag class="mr-2 bg-blue-50 text-blue-600 font-semibold">Developed by: {{item.author_name}}</Tag>
                                </template>
                                <template #footer v-if="store.hasPermission('can-install-module')">
                                    <Button icon="pi pi-check"
                                            class="p-button-success"
                                            data-testid="modules-install-installed-button"
                                            v-if="store.isInstalled(item)" label="Installed"></Button>
                                    <Button icon="pi pi-download"
                                            class="p-button-outlined"
                                            data-testid="modules-install-install-button"
                                            v-else
                                            @click="store.install(item)" label="Install"></Button>
                                </template>
                            </Card>
                        </div>
                    </div>
                    <hr class="my-0"/>
                    <Paginator v-model:rows="store.modules_query.rows"
                               :totalRecords="store.modules.list.total"
                               class="bg-white-alpha-0 pt-2"
                               @page="store.modulesPaginate($event)"
                               data-testid="modules-install-action-pagination"
                               :rowsPerPageOptions="store.rows_per_page"
                    />
                </template>
            </Card>
        </div>
    </div>
</template>
