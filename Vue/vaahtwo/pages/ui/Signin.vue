<template>
    <Card style="width: 28rem;max-width: 100vw; margin-bottom: 2em" class="m-auto">
        <template #title>
            <div class="content text-center">
                <img src="http://irisrishu.com/vaahcms/backend/vaahone/images/vaahcms-logo.svg" alt="" class="w-5 mb-2">
                <h4 class="text-xl font-semibold line-height-2 mb-2">Welcome Back</h4>
                <p class="text-sm text-gray-600 font-semibold mb-4">Please Sign in to continue</p>
            </div>
        </template>
        <template #content>
            <div class="field mb-5">
                <div class="field-radiobutton cursor-pointer">
                    <RadioButton name="Password" value="password" class="is-small" v-model="signInType" inputId="passowrd" />
                    <label for="password" class="text-sm">Login Via Password</label>
                </div>
                <div class="field-radiobutton cursor-pointer">
                    <RadioButton name="OTP" value="otp" class="is-small" v-model="signInType" inputId="otp"/>
                    <label for="otp" class="text-sm">Login Via OTP</label>
                </div>
            </div>
            <div class="p-float-label field mb-5">
                <InputText id="username" class="w-full" type="text" v-model="username" />
                <label for="username">Enter Username or Email</label>
            </div>
            <div v-if="signInType === 'password'" class="p-float-label field mb-5">
                <Password v-model="password" class="w-full" inputClass="w-full" toggleMask id="password"></Password>
                <label for="password">Enter Password</label>
            </div>
            <div v-if="signInType === 'otp'" class="mb-5">
                <Button label="Generate OTP" class="mb-5 p-button-sm"></Button>
               <div class="p-float-label field">
                   <InputText type="number" class="w-full" id="otp"/>
                   <label for="otp">Enter OTP</label>
               </div>
            </div>
            <div class="field flex justify-content-between align-items-center">
                <router-link to="/ui/public/multi-factor-auth">

                <Button label="Sign In" class="p-button-sm" />
                </router-link>
                <router-link to="/ui/public/forgot-password">
                    <Button label="Forgot Password?" class="p-button-text p-button-sm"/>
                </router-link>
            </div>
        </template>
        <template #footer>
            <div class="text-xs text-center"><p>
                © 2022.
                <a class="text-blue-400" href="https://vaah.dev/cms" target="_blank">VaahCMS</a>
                v1.6.10
                | <a class="text-blue-400" href="https://docs.vaah.dev/vaahcms" target="_blank">Documentation</a></p> <p class="has-text-centered">
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
