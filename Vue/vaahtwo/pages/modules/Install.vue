<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

import {useModuleStore} from '../../stores/store-modules';

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";

const store = useModuleStore();
const route = useRoute();

import { useConfirm } from "openvue/useconfirm";
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
        <div v-if="store.modules.list && store.modules.list.data && store.assets">
            <Card>
                <template #header>
                    <div class="flex justify-content-between align-items-center">
                        <h2 class="white-space-nowrap font-semibold vc-text-20">{{store.assets.language_strings.install_modules}}</h2>
                        <InputGroup class="justify-content-end w-6">
                                <IconField>
                                    <InputIcon class="pi pi-search" />
                                    <InputText aria-label="Search modules" :placeholder=store.assets.language_strings.install_placeholder_search
                                               class="w-full"
                                               type="search"
                                               v-model="store.modules.query_string.q"
                                               @input="store.delayedSearch"
                                               @keyup.enter.prevent="store.delayedSearch">
                                               data-testid="modules-install-filter_input"
                                    </InputText>
                                </IconField>
                            <Button size="small" class="" data-testid="modules-install-filter_button" @click="store.closeInstallModule()" icon="pi pi-times" aria-label="Close"></Button>
                        </InputGroup>
                    </div>
                </template>
                <template #content>
                    <div class="flex flex-wrap">
                        <div class="col-12 lg:col-6" v-for="item in store.modules.list.data">
                            <Card>
                                <template #header>
                                    <img class="w-full" :src="item.thumbnail"/>
                                </template>
                                <template #content>
                                    <h2 class="vc-text-16 font-semibold mb-1">{{item.title}}</h2>
                                    <p class="mb-3 vc-text-13 vc-muted">{{item.excerpt}}</p>
                                    <Tag class="mr-2 mb-2">{{store.assets.language_strings.name}}:{{item.title}}</Tag>
                                    <Tag class="mr-2 mb-2">{{store.assets.language_strings.version}}: {{item.version}}</Tag>
                                    <Tag class="mr-2 mb-2">{{store.assets.language_strings.developed_by}}: {{item.author_name}}</Tag>
                                </template>
                                <template #footer v-if="store.hasPermission('can-install-module')">
                                    <Button icon="pi pi-check"
                                            class="p-button-success"
                                            data-testid="modules-install-installed-button"
                                            v-if="store.isInstalled(item)" :label=store.assets.language_strings.installed_button></Button>
                                    <Button icon="pi pi-download"
                                            class="p-button-outlined"
                                            data-testid="modules-install-install-button"
                                            v-else
                                            @click="store.install(item)" :label=store.assets.language_strings.install_button></Button>
                                </template>
                            </Card>
                        </div>
                    </div>
                    <hr style="margin-top: 0;"/>
                </template>
            </Card>
        </div>

        <Paginator v-model:rows="store.modules_query.rows"
                   :totalRecords="store.modules.list.total"
                   @page="store.modulesPaginate($event)"
                   data-testid="modules-install-action-pagination"
                   :rowsPerPageOptions="store.rows_per_page"
        />
    </div>
</template>
