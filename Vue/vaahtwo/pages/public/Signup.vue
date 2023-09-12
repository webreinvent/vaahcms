<script setup>
import {onMounted, reactive, ref,watch} from "vue";
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

    document.title = 'Sign Up';
    root.showResponse(route.query);
    auth.verifyInstallStatus();
    await root.getAssets();
    await root.checkSignupPageVisible();

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
                                <h4 class="text-xl font-semibold line-height-2 mb-2">Welcome</h4>
                                <p class="text-sm text-gray-600 font-semibold">Please Sign up to continue</p>
                            </div>
                        </template>

                        <template #content>
                            <div class="flex flex-column align-items-center gap-3">
                                <div class="w-full gap-3 flex flex-column">
                                    <InputText
                                        name="signup-name"
                                        placeholder="Enter First Name"
                                        data-testid="signup-name"
                                        id="name"
                                        class="w-full"
                                        type="text"
                                        v-model="auth.sign_up_items.first_name"
                                    />
                                </div>

                                <div class="w-full gap-3 flex flex-column">
                                    <InputText
                                        name="signup-last_name"
                                        placeholder="Enter Last Name"
                                        data-testid="signup-last_name"
                                        id="last_name"
                                        class="w-full"
                                        type="text"
                                        v-model="auth.sign_up_items.last_name"
                                    />
                                </div>

                                <div class="w-full gap-3 flex flex-column">
                                    <InputText
                                        name="signup-username"
                                        placeholder="Enter Username"
                                        data-testid="signup-username"
                                        id="username"
                                        class="w-full"
                                        type="text"
                                        v-model="auth.sign_up_items.username"
                                    />
                                </div>

                                <div class="w-full gap-3 flex flex-column">
                                    <InputText
                                        name="signup-email"
                                        placeholder="Enter Email"
                                        data-testid="signup-email"
                                        id="email"
                                        class="w-full"
                                        type="email"
                                        v-model="auth.sign_up_items.email"
                                    />
                                </div>

                                <div class="w-full gap-3 flex flex-column">
                                    <Password
                                        name="signup-password"
                                        placeholder="Enter Password"
                                        data-testid="signup-password"
                                        id="password"
                                        class="w-full" inputClass="w-full"
                                        :feedback="false"
                                        toggleMask
                                        v-model="auth.sign_up_items.password"
                                    />
                                </div>

                                <div class="w-full gap-3 flex flex-column">
                                    <Password
                                        name="signup-confirm_password"
                                        placeholder="Enter Confirm Password"
                                        data-testid="signup-confirm_password"
                                        id="confirm_password"
                                        class="w-full" inputClass="w-full"
                                        :feedback="false"
                                        toggleMask
                                        v-model="auth.sign_up_items.confirm_password"
                                    />
                                </div>

                                <div class="w-full flex justify-content-between align-items-center">
                                    <router-link to="/signup">
                                        <Button
                                            name="signup"
                                            data-testid="signup"
                                            label="Submit"
                                            class="p-button-sm"
                                            :loading="auth.is_btn_loading"
                                            @click="auth.signUp()"
                                        />
                                    </router-link>

                                    <router-link to="/">
                                        <Button
                                            class="p-button-text p-button-sm"
                                            name="signin"
                                            data-testid="signin"
                                            label="Sign In"
                                        />
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
    </div>
</template>

