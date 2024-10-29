<script setup>

import {onMounted, reactive} from "vue";

import { useSetupStore } from '../../../stores/setup'
const store = useSetupStore();
import { useRootStore } from '../../../stores/root'
import Footer from "../../../components/organisms/Footer.vue"
import Logo from "../../../components/molecules/Logo.vue";

const root = useRootStore();


onMounted(async () => {
    document.title = 'Setup';
    await store.getAssets();
    await store.getStatus();
    await store.getAdvancedOptionMenu();
});
</script>

<template>
    <div v-if="store && store.assets && root && root.assets" class="setup">




        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="col-span-4 col-start-2" v-if="store.assets.is_installed">
                <Message severity="success">VaahCMS is successfully setup</Message>
            </div>
            <div >
                <Card class="border-round-xl">
                    <template #title>
                        <div class="flex flex-row justify-between items-center">
                            <h4 class="text-xl font-semi-bold">Install</h4>

                            <div class="flex flex-row justify-end items-center">

                                <a v-if="root.assets.auth_user"
                                   @click="$router.push({name:'dashboard'})">
                                    <Button icon="pi pi-server" rounded outlined
                                            class="mr-2"
                                            data-testid="setup-dashboard_button"
                                            v-tooltip.top="'Dashboard'"
                                    />
                                </a>

                                <a v-else-if="store.assets.is_installed"
                                   @click="$router.push({name:'sign.in'})"
                                >
                                    <Button rounded outlined
                                            class="mr-2"
                                            data-testid="setup-signin_button"
                                            v-tooltip.top="'Sign In'"
                                            icon="pi pi-sign-in"
                                    />
                                </a>


                                <a href="https://docs.vaah.dev/" target="_blank">
                                    <Button icon="pi pi-book" rounded outlined
                                            data-testid="setup-documentation_button"
                                            v-tooltip.top="'Documentation'" />
                                </a>
                            </div>


                        </div>
                    </template>
                    <template #content>
                        <p class="text-left">
                            <a href="https://vaah.dev/cms" target="_blank">VaahCMS
                            </a> is a web application development platform shipped with headless
                            content management system
                        </p>

                    </template>
                    <template #footer>
                        <div v-if="store.status" class="flex flex-row justify-start items-start">
                            <Button v-if="store.status.stage && store.status.stage === 'installed'"
                                    class="mr-4"
                                    disabled label="Install"
                                    icon="pi pi-server"/>

                            <Button v-else label="Install" icon="pi pi-server"
                                    class="mr-4"
                                    @click="store.routeAction('setup.install.configuration')"
                                    data-testid="setup-install_vaahcms"/>

                            <SplitButton label="Advanced Options"
                                         :model="store.advanced_option_menu_list">

                            </SplitButton>
                        </div>
                    </template>
                </Card>
            </div>
            <div >
                <Card class="border-round-xl">
                    <template #title>
                        <div class="flex flex-row justify-between items-center">
                            <h4 class="text-xl font-semi-bold">Reset</h4>
                            <Button icon="pi pi-refresh" rounded outlined
                                    v-tooltip.top="'Refresh'"
                                    @click="store.getStatus()" />
                        </div>
                    </template>
                    <template #content>
                        <p class="text-left">
                            You can reset/re-install the application if you're logged in from "Administrator" account.
                        </p>

                    </template>
                    <template #footer >
                        <div v-if="store.status" class="flex justify-content-between align-items-center">
                            <Button v-if="store.status.is_user_administrator"
                                    @click="store.show_reset_modal = true"
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






        <Dialog header="Reset"
                v-model:visible="store.show_reset_modal"
                :breakpoints="{'960px': '75vw', '640px': '90vw'}"
                :style="{width: '50vw'}">


            <Message severity="error" icon="null" :closable="false">
                <p>You are going to <b>RESET</b> the application.
                    This will remove all the data of the application.</p>
                <p>After reset you <b>CANNOT</b> be restored data!
                    Are you <b>ABSOLUTELY</b> sure?</p>
            </Message>

            <div>
                <p>This action can lead to data loss.
                    To prevent accidental actions we ask you to confirm your intention.</p>

                <p class="has-margin-bottom-5">
                    Please type <b>RESET</b> to proceed and click
                    Confirm button or close this modal to cancel.
                </p>
            </div>

            <InputText v-model="store.reset_inputs.confirm"
                       placeholder="Type RESET to Confirm" class="p-inputtext-md"
                       required
            />

            <div class="mt-2" v-if="store.reset_inputs.confirm === 'RESET' ">
                <div class="field-checkbox">
                    <Checkbox inputId="delete_media"
                              v-model="store.reset_inputs.delete_media"
                              value="true"
                    />
                    <label>
                        Delete Files From Storage (storage/app/public)
                    </label>
                </div>

                <div class="field-checkbox">
                    <Checkbox inputId="delete_dependencies"
                              v-model="store.reset_inputs.delete_dependencies"
                              value="true"
                    />
                    <label>
                        Delete Dependencies (Modules & Themes)
                    </label>
                </div>
            </div>

            <template #footer>
                <Button label="No"
                        icon="pi pi-times"
                        @click="store.show_reset_modal = false"
                        class="p-button-text"/>

                <Button class="p-button-danger"
                        label="Confirm"
                        icon="pi pi-check"
                        :loading="store.reset_confirm"
                        @click="store.confirmReset()"
                        autofocus />
            </template>
        </Dialog>
    </div>
</template>


