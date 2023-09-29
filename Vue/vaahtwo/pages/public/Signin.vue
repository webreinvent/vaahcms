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
        <div class="col-12 mt-6 mx-auto">
            <div class="grid flex justify-content-center flex-wrap ">
                <div v-if="root.assets" class="w-full">
                    <Card class="m-auto border-round-xl w-full max-w-24rem">
                        <template #title>
                            <div class="content text-center">
                                <Logo class="mt-3" />
                                <h4 class="text-xl font-semibold mb-1"
                                    data-testid="signin-heading_text">{{ auth.title.heading }}</h4>
                                <p class="text-xs text-gray-600 font-normal"
                                   data-testid="signin-description_text">{{ auth.title.description }}</p>

                            </div>
                        </template>

                        <template #content>
                            <div class="flex flex-column align-items-center gap-3 ">
                                <div v-if="auth.is_mfa_visible" class="w-full">
                                    <div class="mt-5">
                                        <InputText id="code"
                                                   v-model="auth.verification_otp"
                                                   placeholder="Enter Code"
                                                   data-testid="signin-otp_field"
                                                   class="w-full"/>

                                        <div class="field flex justify-content-between align-items-center">
                                            <Button label="Submit OTP" class="p-button-sm"
                                                    @click="auth.verifySecurityOtp"
                                                    :loading="auth.is_btn_loading"
                                                    data-testid="signin-check_verification" />
                                            <Button v-if="auth.is_resend_disabled"
                                                    :label="'Resend OTP in '+auth.security_timer+' secs..'"
                                                    disabled
                                                    class="p-button-sm"/>
                                            <Button v-else
                                                    label="Resend OTP"
                                                    data-testid="signin-resend_verification"
                                                    @click="auth.resendSecurityOtp"
                                                    class="p-button-sm"/>


                                        </div>
                                    </div>
                                </div>

                                <div v-else class="w-full">

                                    <div class="field mb-3">
                                        <div class="field-radiobutton cursor-pointer">
                                            <RadioButton
                                                name="signin-login_with_password"
                                                data-testid="signin-login_with_password"
                                                value="password"
                                                v-model="auth.sign_in_items.type"
                                                inputId="password"/>
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


                                    <div class="flex flex-column align-items-center gap-3" >
                                        <div v-if="auth.sign_in_items.type === 'password'" class="w-full gap-3 flex flex-column">
                                        <InputText
                                            name="signin-email"
                                            placeholder="Enter Username or Email"
                                            data-testid="signin-email"
                                            id="email"
                                            class="w-full"
                                            type="text"
                                            v-model="auth.sign_in_items.email"/>
                                        <div  class="w-full">
                                            <Password
                                                name="signin-password"
                                                placeholder="Enter Password"
                                                data-testid="signin-password"
                                                v-model="auth.sign_in_items.password"
                                                class="w-full" inputClass="w-full"
                                                :feedback="false"
                                                toggleMask
                                                id="password"
                                                :pt="{
                                                       showicon: {
                                                             'data-testid': `signin-password_eye`
                                                       }
                                                 }"></Password>

                                        </div>
                                        </div>

                                        <div v-if="auth.sign_in_items.type === 'otp'" class="w-full">
                                            <div class="flex flex-column align-items-center gap-3">
                                                <div class="p-inputgroup flex-1">
                                                    <InputText
                                                        name="signin-email"
                                                        placeholder="Enter Username or Email"
                                                        data-testid="signin-email"
                                                        id="email"
                                                        type="text"
                                                        v-model="auth.sign_in_items.email"/>
                                                    <Button
                                                        name="signin-generate_otp_btn"
                                                        data-testid="signin-generate_otp_btn"
                                                        label="Generate OTP"
                                                        class="p-button-sm"
                                                        :loading="auth.is_otp_btn_loading"
                                                        @click="auth.generateOTP()" />
                                                </div>
                                                <InputText
                                                    name="signin-otp"
                                                    placeholder="Enter OTP"
                                                    data-testid="signin-otp"
                                                    type="number"
                                                    class="w-full"
                                                    id="otp"
                                                    v-model="auth.sign_in_items.login_otp"/>

                                            </div>


                                        </div>
                                        <div class="w-full flex justify-content-between align-items-center">
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
                                    </div>

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

    </div>
</template>


