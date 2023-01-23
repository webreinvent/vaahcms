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
            <Card>
                <template #header>
                    <div class="flex justify-content-between align-items-center">
                        <h5 class="white-space-nowrap font-semibold text-lg">Install Modules</h5>
                        <div class="p-inputgroup justify-content-end w-6">
                                <span class="p-input-icon-left">
                                    <i class="pi pi-search" />
                                    <InputText placeholder="Search"
                                               class="w-full"
                                               type="search"
                                               icon="search"
                                               v-model="store.modules.query_string.q"
                                               @input="store.delayedSearch"
                                               @keyup.enter.prevent="store.delayedSearch">
                                    </InputText>
                                </span>
                            <Button class="p-button-sm"
                                    @click="store.closeInstallModule()"
                                    icon="pi pi-times"></Button>
                        </div>
                    </div>
                </template>
                <template #content>
                    <div class="flex flex-wrap">
                        <div class="col-6" v-for="item in store.modules.list.data">
                            <Card>
                                <template #header>
                                    <img :src="item.thumbnail" style="height: 15rem" />
                                </template>
                                <template #content>
                                    <h5 class="text-xl font-semibold mb-1">{{item.title}}</h5>
                                    <p class="mb-3 text-sm">{{item.excerpt}}</p>
                                    <Tag class="mr-2 mb-2">Name:{{item.title}}</Tag>
                                    <Tag class="mr-2 mb-2">Version: {{item.version}}</Tag>
                                    <Tag class="mr-2 mb-2">Developed by: {{item.author_name}}</Tag>
                                </template>
                                <template #footer v-if="store.hasPermission('can-install-module')">
                                    <Button icon="pi pi-check"
                                            class="p-button-success"
                                            v-if="store.isInstalled(item)" label="Installed"></Button>
                                    <Button icon="pi pi-download"
                                            class="p-button-outlined"
                                            v-else
                                            @click="store.install(item)" label="Install"></Button>
                                </template>
                            </Card>
                        </div>
                    </div>
                    <hr style="margin-top: 0;"/>
                </template>
            </Card>
        </div>

        <Paginator v-model:rows="store.query.rows"
                   :totalRecords="store.modules.list.total"
                   @page="store.paginate($event)">
        </Paginator>
    </div>
</template>
