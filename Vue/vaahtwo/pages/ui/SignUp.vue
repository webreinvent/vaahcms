<template>
    <Card style="width: 28rem;max-width: 100vw; margin-bottom: 2em" class="m-auto">
        <template #title>
            <div class="content text-center mb-4">
                <img src="http://irisrishu.com/vaahcms/backend/vaahone/images/vaahcms-logo.svg" alt="" class="w-5 mb-2">
                <h4 class="text-xl font-semibold line-height-2 mb-2">Welcome</h4>
                <p class="text-sm text-gray-600 font-semibold">Please create an account to continue</p>
            </div>
        </template>
        <template #content>
            <div class="p-float-label field mb-5">
                <InputText id="first-name" class="w-full" type="text" v-model="first_name" />
                <label for="first-name">Enter First Name</label>
            </div>
            <div class="p-float-label field mb-5">
                <InputText id="last-name" class="w-full" type="text" v-model="last_name" />
                <label for="last-name">Enter Last Name</label>
            </div>
            <div class="p-float-label field mb-5">
                <InputText id="username" class="w-full" type="text" v-model="username" />
                <label for="username">Enter Username</label>
            </div>
            <div class="p-float-label field mb-5">
                <InputText id="username" class="w-full" type="text" v-model="username" />
                <label for="username">Enter Email</label>
            </div>
            <div class="p-float-label field mb-5">
                <Password v-model="password" class="w-full" inputClass="w-full" toggleMask id="password"></Password>
                <label for="password">Enter Password</label>
            </div>
            <div class="p-float-label field mb-5">
                <Password v-model="confirm_password" class="w-full" inputClass="w-full" toggleMask id="confirm-password"></Password>
                <label for="confirm-password">Confirm Password</label>
            </div>
            <div class="field flex justify-content-between align-items-center">
                <Button label="Sign Up" class="p-button-sm" />
                   <span>
                        <p class="text-sm inline mr-1">Already have an account!</p>
                <router-link to="/public/signin">
                    <a class="text-sm">Sign in</a>
                </router-link>
                   </span>
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
name: "SignUp",
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

<style scoped>

</style>
