<script setup>

import {onMounted, reactive} from "vue";

import { useSetupStore } from '../../../stores/setup'
const store = useSetupStore();
import { useRootStore } from '../../../stores/root'
import Footer from "../../../components/organisms/Footer.vue"

const root = useRootStore();


onMounted(async () => {
    await store.getAssets();
    await store.getStatus();
    await store.getAdvancedOptionMenu();
});
</script>

<template>
    <div v-if="store && store.assets && root && root.assets" class="setup text-center">
        <img src="http://irisrishu.com/vaahcms/backend/vaahone/images/vaahcms-logo.svg" alt="" class="w-1 mb-5">
        <div class="grid justify-content-center">
            <div v-if="store.assets.is_installed" class="col-12">
                <Message severity="success">VaahCMS is successfully setup</Message>
            </div>
            <div class="col-6">
                <Card>
                    <template #title>
                        <div class="flex justify-content-between align-items-center">
                            <h4 class="text-xl font-semi-bold">Install</h4>
                            <div class="icons flex">
                                <div v-if="root.assets.auth_user" class="m-1">
                                    <i class="bg-gray-200 p-2 border-round-3xl pi pi-server"
                                       v-tooltip.top="'Dashboard'">

                                    </i>
                                </div>
                                <div class="m-1">
                                    <a href="https://docs.vaah.dev/vaahcms/installation.html" target="_blank">
                                        <i class="bg-gray-200 active:text-black
                                        p-2 border-round-3xl pi pi-book"
                                           v-tooltip.top="'Documentation'"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template #content>
                        <p class="text-sm text-left">
                            <a href="https://vaah.dev/cms" target="_blank">VaahCMS
                            </a> is a web application development platform shipped with headless
                            content management system
                        </p>
                        <div v-if="store.status" class="flex justify-content-between align-items-center mt-4">
                            <Button v-if="store.status.stage && store.status.stage === 'installed'"
                                    disabled label="Install" icon="pi pi-server"
                                    class="p-button bg-white border-gray-800 text-black-alpha-80"/>

                            <Button v-else label="Install" icon="pi pi-server"
                                    @click="store.routeAction('setup.install.configuration')"
                                    class="p-button bg-white border-gray-800 text-black-alpha-80"/>

                            <SplitButton label="Advanced Options"
                                         :model="store.advanced_option_menu_list"
                                         class="mb-2 p-button-sm">

                            </SplitButton>
                        </div>
                    </template>
                </Card>
            </div>
            <div class="col-6">
                <Card class="h-full">
                    <template #title>
                        <div class="flex justify-content-between align-items-center">
                            <h4 class="text-xl font-semi-bold">Reset</h4>
                            <div class="icons flex">
                                <div class="m-1">
                                    <i class="bg-gray-200 p-2 border-rounded pi pi-refresh"></i>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template #content>
                        <p class="text-sm text-left">
                            You can reset/re-install the application if you're logged in from "Administrator" account.
                        </p>
                        <div v-if="store.status" class="flex justify-content-between align-items-center mt-4">
                            <Button v-if="store.status.is_user_administrator"
                                    label="Reset"
                                    icon="pi pi-refresh"
                                    class="p-button-danger" />

                            <Button v-else
                                    label="Reset"
                                    icon="pi pi-refresh"
                                    class="p-button-danger"
                                    disabled />
                        </div>
                    </template>
                </Card>
            </div>
        </div>

        <Footer />
    </div>
</template>

<style lang="scss" scoped>
.p-card .p-card-body {
    padding: 0.85rem 1rem;
}
.p-button{
    padding: 5px 8px;
}
.p-card .p-card-content {
    padding: 1rem 0 0 0;
}
</style>
