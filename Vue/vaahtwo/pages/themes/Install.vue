<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

import {useThemeStore} from '../../stores/store-themes'

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";

const store = useThemeStore();
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
    await store.getThemes();
});

</script>
<template>
    <div class="column col-6" >
        <div v-if="store.themes && store.themes.data">
            <Card>
                <template #header>
                    <div class="flex justify-content-between align-items-center">
                        <h5 class="white-space-nowrap font-semibold text-lg">Install Themes</h5>
                        <div class="p-inputgroup justify-content-end w-6">
                            <span class="p-input-icon-left">
                                <i class="pi pi-search" />
                                <InputText placeholder="Search"
                                           class="w-full p-inputtext-sm"
                                           type="search"
                                           icon="search"
                                           v-model="store.query.q"
                                           @input="store.delayedSearch"
                                           data-testid="themes-install-action-search"
                                           @keyup.enter.prevent="store.delayedSearch"
                                />
                            </span>

                            <Button class="p-button-sm"
                                    @click="store.closeInstallTheme()"
                                    data-testid="themes-install-action-close"
                                    icon="pi pi-times"
                            />
                        </div>
                    </div>
                </template>
                <template #content>
                    <div class="col-12 md:col-6" v-for="item in store.themes.data">
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
                            <template #footer v-if="store.hasPermission('can-install-theme')">
                                <Button icon="pi pi-check"
                                        class="p-button-success"
                                        v-if="store.isInstalled(item)"
                                        data-testid="themes-install-action-check_installed"
                                        label="Installed"></Button>
                                <Button icon="pi pi-download"
                                        class="p-button-outlined"
                                        data-testid="themes-install-action-install"
                                        v-else
                                        @click="store.install(item)" label="Install"></Button>
                            </template>
                        </Card>
                    </div>
                    <hr style="margin-top: 0;"/>
                </template>
            </Card>
        </div>

        <Paginator v-model:rows="store.themes_query.rows"
                   :totalRecords="store.themes.total"
                   @page="store.themesPaginate($event)"
                   data-testid="themes-install-action-pagination"
                   :rowsPerPageOptions="store.rows_per_page">
        </Paginator>
    </div>
</template>
