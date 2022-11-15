<script  setup>
import {onMounted, reactive, ref} from "vue";
import { useSetupStore } from '../../stores/setup'
import { useRootStore } from '../../stores/root'
import Footer from '../../components/organisms/Footer.vue'
import {vaah} from "../../vaahvue/pinia/vaah";
import { useAuthStore } from "../../stores/auth";

    const store = useSetupStore();
    const root = useRootStore();
    const auth = useAuthStore();

    onMounted(async () => {
        root.verifyInstallStatus();
        await root.getAssets();

    });
</script>

<template>

    <div v-if="root.assets">
        <Card style="width: 28rem;max-width: 100vw; margin-bottom: 2em" class="m-auto">
            <template #title>
                <div class="content text-center">
                    <img src="http://irisrishu.com/vaahcms/backend/vaahone/images/vaahcms-logo.svg" alt="" class="w-5 mb-2">
                    <h4 class="text-xl font-semibold line-height-2 mb-2">Welcome Back</h4>
                    <p class="text-sm text-gray-600 font-semibold">Please Sign in to continue</p>
                </div>
            </template>
            
            <template #content>
                <div class="field mb-6">
                    <div class="field-radiobutton cursor-pointer">
                        <RadioButton name="Password"
                                     value="password"
                                     v-model="auth.sign_in_items.type"
                                     inputId="passowrd"
                        />
                        <label for="password" class="text-sm">Login Via Password</label>
                    </div>

                    <div class="field-radiobutton cursor-pointer">
                        <RadioButton name="OTP"
                                     value="otp"
                                     v-model="auth.sign_in_items.type"
                                     inputId="otp"/>
                        <label for="otp" class="text-sm">Login Via OTP</label>
                    </div>
                </div>

                <div class="p-float-label field mb-5">
                    <InputText id="email"
                               class="w-full"
                               t ype="text"
                               v-model="auth.sign_in_items.email"
                    />
                    <label for="email">Enter Username or Email</label>
                </div>

                <div v-if="auth.sign_in_items.type === 'password'" class="p-float-label field mb-5">
                    <Password v-model="auth.sign_in_items.password"
                              class="w-full" inputClass="w-full"
                              toggleMask
                              id="password">
                    </Password>
                    <label for="password">Enter Password</label>
                </div>

                <div v-if="auth.sign_in_items.type === 'otp'" class="mb-5">
                    <Button label="Generate OTP"
                            class="mb-5"
                            :loading="auth.is_btn_loading"
                            @click="auth.generateOTP()" />

                    <div class="p-float-label field">
                        <InputText type="number" class="w-full" id="otp" v-model="auth.verification.otp_0"/>
                        <label for="otp">Enter OTP</label>
                    </div>
                </div>

                <div class="field flex justify-content-between align-items-center">
                    <div>
                        <Button v-if="auth && auth.no_of_login_attempt === auth.max_attempts_of_login"
                                label="Sign In"
                                class="p-button-sm p-button-danger"
                                v-tooltip.top="'You have tried maximum attempts'"
                        />

                        <Button v-else
                                label="Sign In"
                                class="p-button-sm"
                                :loading="auth.is_btn_loading"
                                @click="auth.signIn()"
                        />
                    </div>

                    <router-link to="">
                        <Button label="Forgot Password?" class="p-button-text p-button-sm"/>
                    </router-link>
                </div>
            </template>

            <template class="m-0" #footer>
                <Footer />
            </template>
        </Card>
    </div>

</template>


