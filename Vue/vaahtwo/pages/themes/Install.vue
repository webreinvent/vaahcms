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

import {useThemeStore} from '../../stores/store-themes'

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";

const store = useThemeStore();
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
    await store.getThemes();
});

</script>
<template>
    <div class="column col-6" >
        <div v-if="store.themes && store.themes.data && store.assets">
            <Card>
                <template #header>
                    <div class="flex justify-content-between align-items-center">
                        <h2 class="white-space-nowrap font-semibold vc-text-20">
                            {{store.assets.language_strings.install_themes}}
                        </h2>
                        <!--
                            M6-T3 (F22) — the v3 hand-rolled icon-side span
                            (its utility class was removed in PrimeFlex v4
                            and has no positioning rule left in the v4
                            pipeline) becomes the v4 icon-addon pattern:
                            the icon moves into an `InputGroupAddon` beside
                            the input (PrimeVue v4 InputGroup docs pattern).
                            M6-T5 — the v4 `InputText` is a bare input: it
                            has no icon prop/slot, so the `icon="search"`
                            attribute that used to sit on it was inert in
                            both v3 and v4. It is removed — the visible
                            search glyph is the `InputGroupAddon` icon.
                        -->
                        <InputGroup class="justify-content-end w-6">
                            <InputGroupAddon>
                                <i class="pi pi-search" />
                            </InputGroupAddon>
                            <InputText aria-label="Search themes" size="small" :placeholder=store.assets.language_strings.themes_install_placeholder_search class="w-full" type="search" v-model="store.query.q" @input="store.delayedSearch" data-testid="themes-install-action-search" @keyup.enter.prevent="store.delayedSearch" />

                            <Button size="small" class="" @click="store.closeInstallTheme()" data-testid="themes-install-action-close" icon="pi pi-times" aria-label="Close" />
                        </InputGroup>
                    </div>
                </template>
                <template #content>
                    <div class="col-12 lg:col-6" v-for="item in store.themes.data">
                        <Card>
                            <template #header>
                                <img class="w-full" :src="item.thumbnail" />
                            </template>
                            <template #content>
                                <h2 class="vc-text-16 font-semibold mb-1">{{item.title}}</h2>
                                <p class="mb-3 vc-text-13 vc-muted">{{item.excerpt}}</p>
                                <Tag class="mr-2 mb-2">{{store.assets.language_strings.themes_name}}:{{item.title}}</Tag>
                                <Tag class="mr-2 mb-2">{{store.assets.language_strings.themes_version}}: {{item.version}}</Tag>
                                <Tag class="mr-2 mb-2">{{store.assets.language_strings.themes_developed_by}}: {{item.author_name}}</Tag>
                            </template>
                            <template #footer v-if="store.hasPermission('can-install-theme')">
                                <Button icon="pi pi-check"
                                        class="p-button-success"
                                        v-if="store.isInstalled(item)"
                                        data-testid="themes-install-action-check_installed"
                                        :label="store.assets.language_strings.themes_installed_button"></Button>
                                <Button icon="pi pi-download"
                                        class="p-button-outlined"
                                        data-testid="themes-install-action-install"
                                        v-else
                                        @click="store.install(item)" :label="store.assets.language_strings.themes_install_button"></Button>
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
