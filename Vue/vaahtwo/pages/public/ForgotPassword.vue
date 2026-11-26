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
import Footer from "../../components/organisms/Footer.vue";
import Logo from "../../components/molecules/Logo.vue";


import { useAuthStore } from '../../stores/auth';
import {useRootStore} from "../../stores/root";
const root = useRootStore();
const auth = useAuthStore();

onMounted(async () => {
    document.title = 'Forgot Password';
    await root.getAssets();
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
                            <h1 class="vc-text-20 font-semibold mb-1"
                                data-testid="forgot_password-heading_text">Forgot password?</h1>
                            <p class="vc-text-13 vc-muted font-normal"
                               data-testid="forgot_password-description_text">You can recover your password from here.</p>

                        </div>
                    </template>

                    <template #content>
                        <div class="flex flex-column align-items-center gap-3 ">
                            <InputGroup>
                                <label class="vaah-sr-only" for="forgot-password-email">Email</label>
                                <InputText
                                    v-model="auth.forgot_password_items.email"
                                    placeholder="Enter Email Address"
                                    name="forgot_password-email"
                                    data-testid="forgot_password-email"
                                    id="forgot-password-email"
                                    class="w-full"
                                    type="text"
                                    required=""
                                />
                                <div class="required-field hidden"></div>
                            </InputGroup>

                            <div class="w-full flex justify-content-between align-items-center">
                                <Button size="small" label="Send Code" name="forgot_password-send_code_btn" data-testid="forgot_password-send_code_btn" class="vaah-btn-primary" native-type="submit" @click="auth.sendCode()" :loading="auth.is_forgot_password_btn_loading" :pt="{ label: { 'data-testid': `forgot_password-send_code_btn_text` } }"/>
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

