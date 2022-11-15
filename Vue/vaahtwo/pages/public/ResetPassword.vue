<script setup>

import {onMounted, reactive} from "vue";
import Footer from "../../components/organisms/Footer.vue"


import { useAuthStore } from '../../stores/auth';
const auth = useAuthStore();

import { useRootStore } from '../../stores/root';
const root = useRootStore();


onMounted(async () => {
    await auth.getAssets();
});

</script>
<template>
    <Card style="width: 28rem;max-width: 100vw; margin-bottom: 2em" class="m-auto">
        <template #title>
            <div class="content text-center" v-if="auth && auth.assets">
                <img :src="auth.assets.backend_logo_url" alt="" class="w-5 mb-2">
                <h4 class="text-xl font-semibold line-height-2 mb-2">Reset password?</h4>
                <p class="text-sm text-gray-600 font-semibold mb-5">You can recover your password from here.</p>
            </div>
        </template>
        <template #content>
            <div>
                <div class="p-float-label field mb-5">
                    <InputText
                        v-model="auth.reset_password_items.reset_password_code"
                        name="reset_password-reset_password_code"
                        data-testid="reset_password-reset_password_code"
                        id="code"
                        class="w-full"
                        type="text"/>
                    <label for="code">Enter Code to reset the password</label>
                </div>
                <div class="p-float-label field mb-5">
                    <Password
                        v-model="auth.reset_password_items.password"
                        name="reset_password-password"
                        data-testid="reset_password-password"
                        class="w-full"
                        inputClass="w-full"
                        toggleMask id="new-password"></Password>
                    <label for="new-password">New Password</label>
                </div>
                <div class="p-float-label field mb-5">
                    <Password
                        v-model="auth.reset_password_items.password_confirmation"
                        name="reset_password-password_confirmation"
                        data-testid="reset_password-password_confirmation"
                        class="w-full"
                        inputClass="w-full"
                        toggleMask id="confirm-password"></Password>
                    <label for="confirm-password">Confirm Password</label>
                </div>
                <div class="field flex justify-content-between align-items-center">
                    <Button
                        label="Recover"
                        class="p-button-sm"
                        @click="auth.resetPassword()"
                        :loading="auth.is_reset_password_btn_loading"/>
                    <router-link :to="{name:'sign.in'}">
                        <Button label="Sign In" class="p-button-text p-button-sm"/>
                    </router-link>
                </div>
            </div>
        </template>
        <template #footer>
            <Footer />
        </template>

    </Card>

</template>
