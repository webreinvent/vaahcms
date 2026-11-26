<template>
    <Card style="width: 28rem;max-width: 100vw; margin-bottom: 2em" class="m-auto">
        <template #title>
            <div class="content text-center mb-4">
                <img src="http://irisrishu.com/vaahcms/backend/vaahone/images/vaahcms-logo.svg" alt="" class="w-5 mb-2">
                <h4 class="vc-text-20 font-semibold line-height-2 mb-2">Welcome</h4>
                <p class="vc-muted vc-text-13 font-semibold">Please create an account to continue</p>
            </div>
        </template>
        <template #content>
            <FloatLabel class="field mb-5">
                <InputText id="first-name" class="w-full" type="text" v-model="first_name" />
                <label for="first-name">Enter First Name</label>
            </FloatLabel>
            <FloatLabel class="field mb-5">
                <InputText id="last-name" class="w-full" type="text" v-model="last_name" />
                <label for="last-name">Enter Last Name</label>
            </FloatLabel>
            <FloatLabel class="field mb-5">
                <InputText id="username" class="w-full" type="text" v-model="username" />
                <label for="username">Enter Username</label>
            </FloatLabel>
            <FloatLabel class="field mb-5">
                <InputText id="username" class="w-full" type="text" v-model="username" />
                <label for="username">Enter Email</label>
            </FloatLabel>
            <FloatLabel class="field mb-5">
                <Password v-model="password" class="w-full" inputClass="w-full" toggleMask id="password"></Password>
                <label for="password">Enter Password</label>
            </FloatLabel>
            <FloatLabel class="field mb-5">
                <Password v-model="confirm_password" class="w-full" inputClass="w-full" toggleMask id="confirm-password"></Password>
                <label for="confirm-password">Confirm Password</label>
            </FloatLabel>
            <div class="field flex justify-content-between align-items-center">
                <Button size="small" label="Sign Up" class="" />
                   <span>
                        <p class="vc-text-13 inline mr-1">Already have an account!</p>
                <router-link to="/public/signin">
                    <a class="vc-text-13">Sign in</a>
                </router-link>
                   </span>
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
