<template>
    <Card style="width: 28rem;max-width: 100vw; margin-bottom: 2em" class="m-auto">
        <template #title>
            <div class="content text-center">
                <img src="http://irisrishu.com/vaahcms/backend/vaahone/images/vaahcms-logo.svg" alt="" class="w-5 mb-2">
                <h4 class="vc-text-20 font-semibold line-height-2 mb-2">Welcome Back</h4>
                <p class="vc-muted vc-text-13 font-semibold mb-4">Please Sign in to continue</p>
            </div>
        </template>
        <template #content>
            <div class="field mb-5">
                <div class="field-radiobutton cursor-pointer">
                    <!-- M7-T4 — the radio `inputId` was misspelled (`passowrd`),
                         so the label bound to the Password *field*; and the
                         OTP radio's id collided with the OTP InputText. The
                         radios now own unique ids and the labels target them. -->
                    <RadioButton name="Password" value="password" class="vc-dense" v-model="signInType" inputId="signin-via-password" />
                    <label for="signin-via-password" class="vc-text-13">Login Via Password</label>
                </div>
                <div class="field-radiobutton cursor-pointer">
                    <RadioButton name="OTP" value="otp" class="vc-dense" v-model="signInType" inputId="signin-via-otp"/>
                    <label for="signin-via-otp" class="vc-text-13">Login Via OTP</label>
                </div>
            </div>
            <FloatLabel class="field mb-5">
                <InputText id="username" class="w-full" type="text" v-model="username" />
                <label for="username">Enter Username or Email</label>
            </FloatLabel>
            <FloatLabel class="field mb-5">
                <Password v-model="password" class="w-full" inputClass="w-full" toggleMask id="password"></Password>
                <label for="password">Enter Password</label>
            </FloatLabel>
            <div v-if="signInType === 'otp'" class="mb-5">
                <Button size="small" label="Generate OTP" class="mb-5"></Button>
               <FloatLabel class="field">
                   <InputText type="number" class="w-full" id="otp"/>
                   <label for="otp">Enter OTP</label>
               </FloatLabel>
            </div>
            <div class="field flex justify-content-between align-items-center">
                <router-link to="/ui/public/multi-factor-auth">

                <Button size="small" label="Sign In" class="" />
                </router-link>
                <router-link to="/ui/public/forgot-password">
                    <Button size="small" label="Forgot Password?" class="p-button-text"/>
                </router-link>
            </div>
        </template>
        <template #footer>
            <div class="vc-text-12 text-center"><p>
                © 2022.
                <a class="vc-link" href="https://vaah.dev/cms" target="_blank">VaahCMS</a>
                v1.6.10
                | <a class="vc-link" href="https://docs.vaah.dev/vaahcms" target="_blank">Documentation</a></p> <p class="text-center">
                Laravel v8.41.0
                | PHP v8.0.18
            </p></div>
        </template>
    </Card>
</template>
<script>
export default {
    name: "Signin",
    data(){
        return{
            signInType: "password",
            username:null,
            password:null,
            otp:null
        }
    },
    methods:{

    }
}
</script>
