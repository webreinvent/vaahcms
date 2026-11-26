<script  setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
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
                    <!-- UT-156 — the sign-in panel was capped at `max-w-24rem`
                         (24 × 14px root = 336px), so the form sat in a narrow
                         column: the OTP row's field was squeezed to 180px
                         beside its action button and the sign-in action
                         row read as two loose ends of a very wide panel.
                         `max-w-30rem` (420px) is the width the auth family
                         uses elsewhere and still keeps the measure short
                         enough for a single-column form (the panel's own
                         content is a field per row, not a paragraph). -->
                    <Card class="m-auto border-round-xl w-full max-w-30rem">
                        <template #title>
                            <div class="content text-center">
                                <Logo class="mt-3" />
                                <h1 class="vc-text-20 font-semibold mb-1"
                                    data-testid="signin-heading_text">{{ auth.title.heading }}</h1>
                                <p class="vc-text-13 vc-muted font-normal"
                                   data-testid="signin-description_text">{{ auth.title.description }}</p>

                            </div>
                        </template>

                        <template #content>
                            <div class="flex flex-column align-items-center gap-3 ">
                                <div v-if="auth.is_mfa_visible" class="w-full">
                                    <div class="mt-5">
                                        <!-- UT-130 (UAT sweep) — the code field
                                             had a placeholder but no label. -->
                                        <label class="vaah-sr-only" for="signin-code-input">Verification code</label>
                                        <InputText id="signin-code-input"
                                                   v-model="auth.verification_otp"
                                                   placeholder="Enter Code"
                                                   data-testid="signin-otp_field"
                                                   class="w-full"/>

                                        <div class="field flex justify-content-between align-items-center">
                                            <Button size="small" label="Submit OTP" class="" @click="auth.verifySecurityOtp" :loading="auth.is_btn_loading" data-testid="signin-check_verification" />
                                            <Button size="small" v-if="auth.is_resend_disabled" :label="'Resend OTP in '+auth.security_timer+' secs..'" disabled class=""/>
                                            <Button size="small" v-else label="Resend OTP" data-testid="signin-resend_verification" @click="auth.resendSecurityOtp" class=""/>


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
                                                inputId="signin-login-type-password"/>
                                            <label for="signin-login-type-password" class="vc-text-13">Login Via Password</label>
                                        </div>
                                        <div class="field-radiobutton cursor-pointer">
                                            <RadioButton
                                                name="signin-login_with_otp"
                                                data-testid="signin-login_with_otp"
                                                value="otp"
                                                v-model="auth.sign_in_items.type"
                                                inputId="signin-login-type-otp"/>
                                            <label for="signin-login-type-otp" class="vc-text-13">Login Via OTP</label>
                                        </div>
                                    </div>


                                    <div class="flex flex-column align-items-center gap-3" >
                                        <div v-if="auth.sign_in_items.type === 'password'" class="w-full gap-3 flex flex-column">
                                        <InputGroup>
                                            <!-- UT-130 (UAT sweep) — placeholder-only
                                                 label; the label is present but not
                                                 rendered, so the field keeps its
                                                 look and gains its name. -->
                                            <label class="vaah-sr-only" for="signin-email-input">Username or Email</label>
                                            <InputText
                                                name="signin-email"
                                                placeholder="Enter Username or Email"
                                                data-testid="signin-email"
                                                id="signin-email-input"
                                                class="w-full"
                                                type="text"
                                                autocomplete="username"
                                                v-model="auth.sign_in_items.email" required/>
                                            <div class="required-field hidden"></div>
                                        </InputGroup>
                                        <InputGroup class="w-full">
                                            <label class="vaah-sr-only" for="signin-password-input">Password</label>
                                            <Password
                                                name="signin-password"
                                                placeholder="Enter Password"
                                                data-testid="signin-password"
                                                v-model="auth.sign_in_items.password"
                                                class="w-full" inputClass="w-full"
                                                :feedback="false"
                                                toggleMask
                                                input-id="signin-password-input"
                                                :input-props="{ autocomplete: 'current-password' }"
                                                :pt="{
                                                    root: {
                                                      required: ''
                                                    },
                                                       showicon: {
                                                             'data-testid': `signin-password_eye`
                                                       }
                                                 }"></Password>
                                            <div class="required-field hidden"></div>
                                        </InputGroup>
                                        </div>

                                        <div v-if="auth.sign_in_items.type === 'otp'" class="w-full">
                                            <div class="flex flex-column gap-3">
                                                <!-- UT-156 — the OTP row was a hand-rolled flex
                                                     line: a 36px field beside a 28px
                                                     `size="small"` button. The small size token
                                                     fixes the button's height, so it could not
                                                     stretch to the field's height and the pair
                                                     read as two unrelated controls — the button
                                                     looked undersized and detached.

                                                     `InputGroup` is the engine's v4 component for
                                                     a field with an attached action (the list
                                                     toolbars already use it: the app's own CSS
                                                     targets `.p-inputgroup > .p-button`). The
                                                     group stretches its children, so the action
                                                     inherits the field's 36px control height,
                                                     and the app's
                                                     `.p-inputgroup .p-inputtext { border-radius:
                                                     2px 0 0 2px }` squares the field's right
                                                     corners so the two controls read as one.

                                                     The field keeps its own `relative` wrapper so
                                                     the required marker anchors to the FIELD, not
                                                     to the group (a marker inside the group would
                                                     land over the button).

                                                     UT-155 — the OTP step asked for "Username
                                                     or Email", but the OTP endpoint validates
                                                     `email => required|email|max:150` and looks
                                                     the user up by email
                                                     (UserBase::beforeUserActionValidation), so
                                                     a username was rejected by the backend. The
                                                     copy now matches the contract. -->
                                                <InputGroup class="w-full">
                                                    <div class="relative flex-1 min-w-0">
                                                        <label class="vaah-sr-only" for="signin-email-otp-input">Email</label>
                                                        <InputText
                                                            name="signin-email"
                                                            placeholder="Enter Email"
                                                            data-testid="signin-email_otp"
                                                            id="signin-email-otp-input"
                                                            type="email"
                                                            autocomplete="email"
                                                            class="w-full"
                                                            v-model="auth.sign_in_items.email" required/>
                                                        <div class="required-field hidden"></div>
                                                    </div>
                                                    <Button name="signin-generate_otp_btn" data-testid="signin-generate_otp_btn" label="Generate OTP" class="" :loading="auth.is_otp_btn_loading" @click="auth.generateOTP()" />
                                                </InputGroup>
                                                <div class="relative w-full">
                                                    <label class="vaah-sr-only" for="signin-otp-input">One-time password</label>
                                                    <InputText
                                                        name="signin-otp"
                                                        placeholder="Enter OTP"
                                                        data-testid="signin-otp"
                                                        type="text"
                                                        inputmode="numeric"
                                                        autocomplete="one-time-code"
                                                        class="w-full"
                                                        id="signin-otp-input"
                                                        v-model="auth.sign_in_items.login_otp" required/>
                                                    <div class="required-field hidden"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-full flex justify-content-between align-items-center">
                                            <div>
                                                <!-- UT-157 — the panel's actions were
                                                     `size="small"` (28px) beside 36px
                                                     fields, so the primary action of
                                                     the screen was the smallest
                                                     control on it. The default size
                                                     is the app's 36px control height
                                                     and lines the action row up with
                                                     the fields above it. -->
                                                <Button v-if="auth && auth.no_of_login_attempt === auth.max_attempts_of_login" name="signin-sign_in_btn" data-testid="signin-sign_in_btn_max_attempts" label="Sign In" class=" p-button-danger" v-tooltip.top="'You have tried maximum attempts'"/>

                                                <Button v-else name="signin-sign_in_btn" data-testid="signin-sign_in_btn" label="Sign In" class="vaah-btn-primary" :loading="auth.is_btn_loading" @click="auth.signIn()"/>
                                            </div>
                                            <!-- UT-84 — the link used to wrap a
                                                 <button>: one interactive control
                                                 nested in another. The link is now
                                                 the single interactive element and
                                                 carries the button's own classes,
                                                 so it looks the same and reads
                                                 the same to a screen reader. -->
                                            <router-link to="/forgot-password"
                                                        class="p-button p-component p-button-text no-underline"
                                                        name="signin-forgot_password_btn"
                                                        data-testid="signin-forgot_password_btn"
                                                        aria-label="Forgot Password?">
                                                <span class="p-button-label">Forgot Password?</span>
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


