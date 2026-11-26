<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
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
                                <h1 class="vc-text-20 font-semibold line-height-2 mb-2">Welcome</h1>
                                <p class="vc-text-13 vc-muted">Please Sign up to continue</p>
                            </div>
                        </template>

                        <template #content>
                            <div class="flex flex-column align-items-center gap-3">
                                <InputGroup class="w-full gap-3 flex flex-column">
                                    <label class="vaah-sr-only" for="signup-name-input">First Name</label>
                                    <InputText
                                        name="signup-name"
                                        placeholder="Enter First Name"
                                        data-testid="signup-name"
                                        id="signup-name-input"
                                        class="w-full"
                                        type="text"
                                        v-model="auth.sign_up_items.first_name"
                                        required
                                    />
                                    <div class="required-field hidden"></div>
                                </InputGroup>

                                <div class="w-full gap-3 flex flex-column">
                                    <label class="vaah-sr-only" for="signup-last_name-input">Last Name</label>
                                    <InputText
                                        name="signup-last_name"
                                        placeholder="Enter Last Name"
                                        data-testid="signup-last_name"
                                        id="signup-last_name-input"
                                        class="w-full"
                                        type="text"
                                        v-model="auth.sign_up_items.last_name"
                                    />
                                </div>

                                <InputGroup class="w-full gap-3 flex flex-column">
                                    <label class="vaah-sr-only" for="signup-username-input">Username</label>
                                    <InputText
                                        name="signup-username"
                                        placeholder="Enter Username"
                                        data-testid="signup-username"
                                        id="signup-username-input"
                                        class="w-full"
                                        type="text"
                                        v-model="auth.sign_up_items.username"
                                        required
                                    />
                                    <div class="required-field hidden"></div>
                                </InputGroup>

                                <InputGroup class="w-full gap-3 flex flex-column">
                                    <label class="vaah-sr-only" for="signup-email-input">Email</label>
                                    <InputText
                                        name="signup-email"
                                        placeholder="Enter Email"
                                        data-testid="signup-email"
                                        id="signup-email-input"
                                        class="w-full"
                                        type="email"
                                        v-model="auth.sign_up_items.email"
                                        required
                                    />
                                    <div class="required-field hidden"></div>
                                </InputGroup>

                                <InputGroup class="w-full gap-3 flex flex-column">
                                    <label class="vaah-sr-only" for="signup-password-input">Password</label>
                                    <Password
                                        name="signup-password"
                                        placeholder="Enter Password"
                                        data-testid="signup-password"
                                        input-id="signup-password-input"
                                        class="w-full" inputClass="w-full"
                                        :feedback="false"
                                        toggleMask
                                        v-model="auth.sign_up_items.password"
                                        :pt="{
                                            root: {
                                                required: ''
                                            }
                                        }"
                                    />
                                    <div class="required-field hidden"></div>
                                </InputGroup>

                                <InputGroup class="w-full gap-3 flex flex-column">
                                    <label class="vaah-sr-only" for="signup-confirm_password-input">Confirm Password</label>
                                    <Password
                                        name="signup-confirm_password"
                                        placeholder="Enter Confirm Password"
                                        data-testid="signup-confirm_password"
                                        input-id="signup-confirm_password-input"
                                        class="w-full" inputClass="w-full"
                                        :feedback="false"
                                        toggleMask
                                        v-model="auth.sign_up_items.confirm_password"
                                        :pt="{
                                            root: {
                                                required: ''
                                            }
                                        }"
                                    />
                                    <div class="required-field hidden"></div>
                                </InputGroup>

                                <div class="w-full flex justify-content-between align-items-center">
                                    <!-- UT-84 — the submit button was wrapped in a
                                         link that navigated to the same route; the
                                         button is now the single interactive
                                         element. The "Sign in" link kept its own
                                         navigation and now *is* the button. -->
                                    <Button size="small" name="signup" data-testid="signup" label="Submit" class="vaah-btn-primary" :loading="auth.is_btn_loading" @click="auth.signUp()" />

                                    <router-link to="/"
                                                class="p-button p-component p-button-text p-button-sm no-underline"
                                                name="signin"
                                                data-testid="signin"
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
    </div>
</template>

