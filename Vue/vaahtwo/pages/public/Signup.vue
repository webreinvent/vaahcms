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
                                <h4 class="text-xl font-semibold line-height-2 mb-2">Welcome</h4>
                                <p class="text-sm text-gray-600 font-semibold">Please Sign up to continue</p>
                            </div>
                        </template>

                        <template #content>
                            <div>
                                <div class="p-float-label field mb-5">
                                    <InputText
                                        name="signin-email"
                                        data-testid="signin-email"
                                        id="username"
                                        class="w-full"
                                        type="text"
                                        v-model="auth.sign_up_items.name"/>
                                    <label for="name">Name</label>
                                </div>

                                <div class="p-float-label field mb-5">
                                    <InputText
                                        name="signin-email"
                                        data-testid="signin-email"
                                        id="email"
                                        class="w-full"
                                        type="text"
                                        v-model="auth.sign_up_items.username"/>
                                    <label for="username">Username</label>
                                </div>

                                <div class="p-float-label field mb-5">
                                    <InputText
                                        name="signin-email"
                                        data-testid="signin-email"
                                        id="email"
                                        class="w-full"
                                        type="text"
                                        v-model="auth.sign_up_items.email"/>
                                    <label for="email">Email</label>
                                </div>
                                <div class="p-float-label field mb-5">
                                    <InputText
                                        name="signin-email"
                                        data-testid="signin-email"
                                        id="email"
                                        class="w-full"
                                        type="text"
                                        v-model="auth.sign_up_items.password"
                                    />
                                    <label for="password">Password</label>
                                </div>

                                <div class="p-float-label field mb-5">
                                    <InputText
                                        name="signin-email"
                                        data-testid="signin-email"
                                        id="email"
                                        class="w-full"
                                        type="text"
                                        v-model="auth.sign_up_items.confirm_password"/>
                                    <label for="email">Confirm Password</label>
                                </div>


                                <div class="field flex justify-content-between align-items-center">

                                    <router-link to="/signup">
                                        <Button
                                            name="signup"
                                            data-testid="signup"
                                            label="Submit"
                                        />
                                    </router-link>


                                    <router-link to="/">
                                        <Button
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


