<script  setup>
import {onMounted, reactive, ref} from "vue";
import { useRootStore } from '../../stores/root'
import Footer from '../../components/organisms/Footer.vue'
import {vaah} from "../../vaahvue/pinia/vaah";
import Logo from "../../components/molecules/Logo.vue";
import { useAuthStore } from "../../stores/auth";
import {useRoute} from "vue-router";

const root = useRootStore();
const auth = useAuthStore();
const route = useRoute();

onMounted(async () => {
    document.title = 'Sign In';
    root.showResponse(route.query);
    auth.verifyInstallStatus();
    await root.getAssets();

});
</script>
<template>
    <div v-if="root.assets && auth.is_installation_verified">
        <div class="grid flex justify-content-center flex-wrap ">
            <div class="col-5 flex align-items-center justify-content-center ">
                <div v-if="root.assets">
                    <Card style="width: 28rem;max-width: 100vw; margin-bottom: 2em" class="m-auto">
                        <template #title>
                            <div class="content text-center">
                                <Logo/>
                                <h4 class="text-xl font-semibold line-height-2 mb-2">Welcome Back</h4>
                                <p class="text-sm text-gray-600 font-semibold">Please Sign in to continue</p>
                            </div>
                        </template>

                        <template #content>
                            <div class="field mb-6">
                                <div class="field-radiobutton cursor-pointer">
                                    <RadioButton
                                        name="signin-login_with_password"
                                        data-testid="signin-login_with_password"
                                        value="password"
                                        v-model="auth.sign_in_items.type"
                                        inputId="passowrd"/>
                                    <label for="password" class="text-sm">Login Via Password</label>
                                </div>
                                <div class="field-radiobutton cursor-pointer">
                                    <RadioButton
                                        name="signin-login_with_otp"
                                        data-testid="signin-login_with_otp"
                                        value="otp"
                                        v-model="auth.sign_in_items.type"
                                        inputId="otp"/>
                                    <label for="otp" class="text-sm">Login Via OTP</label>
                                </div>
                            </div>
                            <div class="p-float-label field mb-5">
                                <InputText
                                    name="signin-email"
                                    data-testid="signin-email"
                                    id="email"
                                    class="w-full"
                                    type="text"
                                    v-model="auth.sign_in_items.email"/>
                                <label for="email">Enter Username or Email</label>
                            </div>
                            <div v-if="auth.sign_in_items.type === 'password'" class="p-float-label field mb-5">
                                <Password
                                    name="signin-password"
                                    data-testid="signin-password"
                                    v-model="auth.sign_in_items.password"
                                    class="w-full" inputClass="w-full"
                                    :feedback="false"
                                    toggleMask
                                    id="password"></Password>
                                <label for="password">Enter Password</label>
                            </div>
                            <div v-if="auth.sign_in_items.type === 'otp'" class="mb-5">
                                <Button
                                    name="signin-generate_otp_btn"
                                    data-testid="signin-generate_otp_btn"
                                    label="Generate OTP"
                                    class="mb-5"
                                    :loading="auth.is_otp_btn_loading"
                                    @click="auth.generateOTP()" />
                                <div class="p-float-label field">
                                    <InputText
                                        name="signin-otp"
                                        data-testid="signin-otp"
                                        type="number"
                                        class="w-full"
                                        id="otp"
                                        v-model="auth.sign_in_items.login_otp"/>
                                    <label for="otp">Enter OTP</label>
                                </div>
                            </div>
                            <div class="field flex justify-content-between align-items-center">
                                <div>
                                    <Button
                                        v-if="auth && auth.no_of_login_attempt === auth.max_attempts_of_login"
                                        name="signin-sign_in_btn"
                                        data-testid="signin-sign_in_btn"
                                        label="Sign In"
                                        class="p-button-sm p-button-danger"
                                        v-tooltip.top="'You have tried maximum attempts'"/>

                                    <Button
                                        v-else
                                        name="signin-sign_in_btn"
                                        data-testid="signin-sign_in_btn"
                                        label="Sign In"
                                        class="p-button-sm"
                                        :loading="auth.is_btn_loading"
                                        @click="auth.signIn()"/>
                                </div>
                                <router-link to="/forgot-password">
                                    <Button
                                        name="signin-forgot_password_btn"
                                        data-testid="signin-forgot_password_btn"
                                        label="Forgot Password?"
                                        class="p-button-text p-button-sm"/>
                                </router-link>
                            </div>
                        </template>
                        <template class="m-0" #footer>
                            <Footer />
                        </template>
                    </Card>
                </div>
            </div>
        </div>
    </div>
</template>


