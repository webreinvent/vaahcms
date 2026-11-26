<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });

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

// UT-81 — the card's icon actions were `<a>` elements *wrapping* a
// `<button>`, which nests one interactive control inside another: the
// markup is invalid HTML, the link has no accessible name of its own and
// the tab order walks a nameless link before the button. The anchor is
// gone — the button is the single interactive element and carries the
// behaviour (the docs link keeps opening in a new tab).
const open_documentation = () => {
    window.open('https://docs.vaah.dev/vaahcms/installation.html', '_blank', 'noopener,noreferrer');
};
</script>

<template>
    <div v-if="store && store.assets && root && root.assets" class="setup text-center">
        <Logo class="w-6 mx-auto" />
        <div class="grid justify-content-center">
            <div v-if="store.assets.is_installed" class="col-12">
                <Message severity="success" :closable="false">VaahCMS is successfully setup</Message>
            </div>
            <!-- UT-59 — `col-6` gave each card half of the row at every
                 width: on a 375px viewport the Install and the Reset card
                 were 170px wide. Below `md` they stack, each full width. -->
            <div class="col-12 md:col-6">
                <Card class="border-round-xl">
                    <template #title>
                        <div class="flex justify-content-between align-items-center">
                            <!-- UT-129 (UAT sweep) — the screen's single
                                 top-level heading is the Install card; the
                                 Reset card is a sibling section under it.
                                 `vc-text-20` pins the size and weight, so
                                 the rendering is unchanged. -->
                            <h1 class="vc-text-20 font-semibold">Install</h1>
                            <div class="icons flex">
                                <div v-if="root.assets.auth_user" class="m-1">
                                    <Button aria-label="Dashboard" size="small" rounded outlined severity="secondary"
                                            data-testid="setup-dashboard_button"
                                            v-tooltip.top="'Dashboard'"
                                            @click="$router.push({name:'dashboard'})"
                                            icon=" pi pi-server"/>
                                </div>
                                <div v-else-if="store.assets.is_installed" class="m-1">
                                    <Button aria-label="Sign in" size="small" rounded outlined severity="secondary"
                                            data-testid="setup-signin_button"
                                            v-tooltip.top="'Sign In'"
                                            @click="$router.push({name:'sign.in'})"
                                            icon="pi pi-sign-in"/>
                                </div>
                                <div class="m-1">
                                    <Button aria-label="Documentation" size="small" rounded outlined severity="secondary"
                                            data-testid="setup-documentation_button"
                                            v-tooltip.top="'Documentation'"
                                            @click="open_documentation"
                                            icon=" pi pi-book"/>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template #content>
                        <!-- M6-T5 — the Card content body is 12.25px
                             (PrimeFlex `text-sm` at the 14px root): off
                             the DESIGN-SYSTEM.md §6 scale and below the
                             reading floor. This is body copy: 14px. -->
                        <!-- M6-T5 — same Card body size as the card
                             above: this is body copy, so it takes the
                             14px body size of the §6 scale. -->
                        <p class="text-left vc-text-14">
                            <a href="https://vaah.dev/cms" target="_blank">VaahCMS
                            </a> is a web application development platform shipped with headless
                            content management system
                        </p>

                    </template>
                    <template #footer>
                        <div v-if="store.status" class="flex justify-content-between align-items-center">
                            <Button size="small" v-if="store.status.stage && store.status.stage === 'installed'" disabled label="Install" icon="pi pi-server" severity="primary" class="vaah-btn-primary"/>

                            <Button v-else label="Install" icon="pi pi-server"
                                    @click="store.routeAction('setup.install.configuration')"
                                    severity="primary" class="vaah-btn-primary"
                                    data-testid="setup-install_vaahcms"/>

                            <!-- UT-132 — the SplitButton's dropdown toggle is an
                                 icon-only button: it carried no accessible
                                 name, so a screen reader announced it as an
                                 unlabelled button. -->
                            <SplitButton size="small" label="Advanced Options" :model="store.advanced_option_menu_list" class=""
                                         :menuButtonProps="{'aria-label': 'Advanced Options menu'}">

                            </SplitButton>
                        </div>
                    </template>
                </Card>
            </div>
            <div class="col-12 md:col-6">
                <Card class="h-full border-round-xl">
                    <template #title>
                        <div class="flex justify-content-between align-items-center">
                            <h2 class="vc-text-20 font-semibold">Reset</h2>
                            <div class="icons flex">
                                <div class="m-1">
                                    <Button aria-label="Refresh" size="small" rounded outlined severity="secondary"
                                            icon="pi pi-refresh"
                                            v-tooltip.top="'Refresh'"
                                            @click="store.getStatus()" />
                                </div>
                            </div>
                        </div>
                    </template>
                    <template #content>
                        <p class="text-left vc-text-14">
                            You can reset/re-install the application if you're logged in from "Administrator" account.
                        </p>

                    </template>
                    <template #footer >
                        <div v-if="store.status" class="flex justify-content-between align-items-center">
                            <Button v-if="store.status.is_user_administrator"
                                    @click="store.show_reset_modal = true"
                                    label="Reset"
                                    icon="pi pi-refresh"
                                    severity="danger" />

                            <Button v-else
                                    label="Reset"
                                    icon="pi pi-refresh"
                                    severity="danger"
                                    disabled />
                        </div>
                    </template>
                </Card>
            </div>
        </div>

        <Footer class="mt-3" />

        <Dialog header="Reset"
                v-model:visible="store.show_reset_modal"
                :breakpoints="{'960px': '75vw', '640px': '90vw'}"
                :style="{width: '50vw'}">


            <!-- UT-103 follow-on — `icon="null"` passed the STRING "null" as
                 the icon class, which is truthy: the engine rendered an empty
                 `<span class="p-message-icon null">` and it indented the text.
                 Omit the attribute to get no icon at all. -->
            <Message severity="error" :closable="false">
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
                        text/>

                <Button severity="danger"
                        label="Confirm"
                        icon="pi pi-check"
                        :loading="store.reset_confirm"
                        @click="store.confirmReset()"
                        autofocus />
            </template>
        </Dialog>
    </div>
</template>


