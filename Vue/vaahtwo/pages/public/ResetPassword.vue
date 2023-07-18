<script setup>

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
                <Card class="m-auto border-round-xl w-full max-w-24rem">
                    <template #title>
                        <div class="content text-center">
                            <Logo class="mt-3" />
                            <h4 class="text-xl font-semibold mb-1">Reset password?</h4>
                            <p class="text-xs text-gray-600 font-normal">
                                ou can recover your password from here.</p>

                        </div>
                    </template>

                    <template #content>
                        <div class="flex flex-column align-items-center gap-3 ">
                            <InputText
                                v-model="auth.reset_password_items.reset_password_code"
                                placeholder="Enter Code to reset the password"
                                name="reset_password-reset_password_code"
                                data-testid="reset_password-reset_password_code"
                                id="code"
                                class="w-full"
                                type="text"/>
                            <Password
                                v-model="auth.reset_password_items.password"
                                placeholder="New Password"

                                name="reset_password-password"
                                :inputProps="{autocomplete:'new-password'}"
                                data-testid="reset_password-password"
                                class="w-full"
                                inputClass="w-full"
                                toggleMask id="new-password"></Password>
                            <Password
                                v-model="auth.reset_password_items.password_confirmation"
                                placeholder="Confirm Password"
                                name="reset_password-password_confirmation"
                                data-testid="reset_password-password_confirmation"
                                class="w-full"
                                inputClass="w-full"
                                toggleMask id="confirm-password"></Password>
                            <div class="w-full flex justify-content-between align-items-center">
                                <Button
                                    label="Recover"
                                    name="reset_password-reset_password_btn"
                                    data-testid="reset_password-reset_password_btn"
                                    class="p-button-sm"
                                    @click="auth.resetPassword()"
                                    :loading="auth.is_reset_password_btn_loading"/>
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
