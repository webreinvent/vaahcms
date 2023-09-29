<script setup>

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
                <Card class="m-auto border-round-xl w-full max-w-24rem">
                    <template #title>
                        <div class="content text-center">
                            <Logo class="mt-3" />
                            <h4 class="text-xl font-semibold mb-1"
                                data-testid="forgot_password-heading_text">Forgot password?</h4>
                            <p class="text-xs text-gray-600 font-normal"
                               data-testid="forgot_password-description_text">You can recover your password from here.</p>

                        </div>
                    </template>

                    <template #content>
                        <div class="flex flex-column align-items-center gap-3 ">
                            <InputText
                                v-model="auth.forgot_password_items.email"
                                placeholder="Enter Email Address"
                                name="forgot_password-email"
                                data-testid="forgot_password-email"
                                id="email"
                                class="w-full"
                                type="text"/>

                            <div class="w-full flex justify-content-between align-items-center">
                                <Button
                                    label="Send Code"
                                    name="forgot_password-send_code_btn"
                                    data-testid="forgot_password-send_code_btn"
                                    class="p-button-sm"
                                    native-type="submit"
                                    @click="auth.sendCode()"
                                    :loading="auth.is_forgot_password_btn_loading"
                                    :pt="{
                                        label: {
                                           'data-testid': `forgot_password-send_code_btn_text`
                                            }
                                    }"/>
                                <router-link :to="{name:'sign.in'}">
                                    <Button label="Sign In" class="p-button-text p-button-sm"/>
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

