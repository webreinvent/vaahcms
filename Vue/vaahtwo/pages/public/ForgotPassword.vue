<script setup>

import {onMounted, reactive} from "vue";
import Footer from "../../components/organisms/Footer.vue";


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
                <img :src="auth.assets.backend_logo_url"
                     alt=""
                     class="w-5 mb-2">
                <h4 class="text-xl font-semibold line-height-2 mb-2">Forgot password?</h4>
                <p class="text-sm text-gray-600 font-semibold mb-5">You can recover your password from here.</p>
            </div>
        </template>
        <template #content>
            <div>
                <form>
                    <div class="p-float-label field mb-5">
                        <InputText
                            v-model="auth.forgot_password_items.email"
                            name="forgot_password-email"
                            data-testid="forgot_password-email"
                            id="email"
                            class="w-full"
                            type="text"/>
                        <label for="email">Enter Email Address</label>
                    </div>
                    <div class="field flex justify-content-between align-items-center">
                        <Button
                            label="Send Code"
                            class="p-button-sm"
                            native-type="submit"
                            @click="auth.sendCode()"
                            :loading="auth.is_forgot_password_btn_loading"/>
                        <router-link :to="{name:'sign.in'}">
                            <Button label="Sign In" class="p-button-text p-button-sm"/>
                        </router-link>
                    </div>
                </form>
            </div>
        </template>
        <template #footer>
            <Footer />
        </template>
    </Card>
</template>

