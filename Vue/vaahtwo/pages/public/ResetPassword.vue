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
import Footer from "../../components/organisms/Footer.vue"
import Logo from "../../components/molecules/Logo.vue";


import { useAuthStore } from '../../stores/auth';
import {useRootStore} from "../../stores/root";
import {useRoute} from "vue-router";
const root = useRootStore();
const auth = useAuthStore();
const route = useRoute();

onMounted(async () => {
    document.title = 'Reset Password';
    await root.getAssets();
    if (route.params && route.params.code) {
        auth.reset_password_items.reset_password_code = route.params.code;
    }
});

</script>
<template>
    <div class="col-12 mt-6 mx-auto">
        <div class="grid flex justify-content-center flex-wrap ">
            <div v-if="root.assets" class="w-full">
                <Card class="m-auto border-round-xl w-full max-w-30rem">
                    <template #title>
                        <div class="content text-center">
                            <Logo class="mt-3" />
                            <h1 class="vc-text-20 font-semibold mb-1">Reset password?</h1>
                            <p class="vc-text-13 vc-muted font-normal">
                                You can recover your password from here.</p>

                        </div>
                    </template>

                    <template #content>
                        <div class="flex flex-column align-items-center gap-3 ">
                            <InputGroup>
                                <label class="vaah-sr-only" for="reset-password-code">Verification code</label>
                                <InputText
                                    v-model="auth.reset_password_items.reset_password_code"
                                    placeholder="Enter Code to reset the password"
                                    name="reset_password-reset_password_code"
                                    data-testid="reset_password-reset_password_code"
                                    id="reset-password-code"
                                    class="w-full"
                                    type="text" required
                                />
                                <div class="required-field hidden"></div>
                            </InputGroup>
                            <InputGroup>
                                <label class="vaah-sr-only" for="reset-password-new">New Password</label>
                                <Password
                                    v-model="auth.reset_password_items.password"
                                    placeholder="New Password"

                                    name="reset_password-password"
                                    :inputProps="{autocomplete:'new-password'}"
                                    data-testid="reset_password-password"
                                    class="w-full"
                                    inputClass="w-full"
                                    toggleMask input-id="reset-password-new"
                                    :pt="{
                                        root: {
                                            required: ''
                                        }
                                    }"
                                ></Password>
                                <div class="required-field hidden"></div>
                            </InputGroup>
                            <InputGroup>
                                <label class="vaah-sr-only" for="reset-password-confirm">Confirm Password</label>
                                <Password
                                    v-model="auth.reset_password_items.password_confirmation"
                                    placeholder="Confirm Password"
                                    name="reset_password-password_confirmation"
                                    data-testid="reset_password-password_confirmation"
                                    class="w-full"
                                    inputClass="w-full"
                                    toggleMask input-id="reset-password-confirm"
                                    :pt="{
                                        root: {
                                            required: ''
                                        }
                                    }"
                                ></Password>
                                <div class="required-field hidden"></div>
                            </InputGroup>
                            <div class="w-full flex justify-content-between align-items-center">
                                <Button size="small" label="Recover" name="reset_password-reset_password_btn" data-testid="reset_password-reset_password_btn" class="vaah-btn-primary" @click="auth.resetPassword()" :loading="auth.is_reset_password_btn_loading"/>
                                <!-- UT-84 — the link wrapped a <button>: one
                                     interactive control nested in another. The link
                                     is now the single interactive element and keeps
                                     the button's own classes. -->
                                <router-link :to="{name:'sign.in'}"
                                            class="p-button p-component p-button-text p-button-sm no-underline"
                                            aria-label="Sign In">
                                    <span class="p-button-label">Sign In</span>
                                </router-link>
                            </div>
                        </div>

                    </template>
                    <template class="m-0" #footer>
                        <Footer />
                    </template>
                </Card>

            </div>
        </div>
    </div>

</template>
