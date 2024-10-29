<template>
    <Card style="width: 28rem;max-width: 100vw; margin-bottom: 2em" class="m-auto">
        <template #title>
            <div class="content text-center">
                <img src="http://irisrishu.com/vaahcms/backend/vaahone/images/vaahcms-logo.svg" alt="" class="w-5 mb-2">
                <h4 class="text-xl font-semibold line-height-2 mb-2">Forgot password?</h4>
                <p class="text-sm text-gray-600 font-semibold mb-5">You can recover your password from here.</p>
            </div>
        </template>
        <template #content>
            <div v-if="code_sent === false">
                <div class="p-float-label field mb-5">
                    <InputText id="email" class="w-full" type="text" v-model="email" />
                    <label for="email">Enter Email Address</label>
                </div>
                <div class="field flex justify-content-between align-items-center">
                    <Button label="Send Code" class="p-button-sm" @click="sendCode" />
                    <router-link to="/public/signin">
                        <Button label="Sign In" class="p-button-text p-button-sm"/>
                    </router-link>
                </div>
            </div>
           <div v-if="code_sent">
               <div class="p-float-label field mb-5">
                   <InputText id="code" class="w-full" type="text" v-model="code"/>
                   <label for="code">Enter Code to reset the password</label>
               </div>
               <div class="p-float-label field mb-5">
                   <Password v-model="new_password" class="w-full" inputClass="w-full" toggleMask id="new-password"></Password>
                   <label for="new-password">New Password</label>
               </div>
               <div class="p-float-label field mb-5">
                   <Password v-model="confirm_password" class="w-full" inputClass="w-full" toggleMask id="confirm-password"></Password>
                   <label for="confirm-password">Confirm Password</label>
               </div>
               <div class="field flex justify-content-between align-items-center">
                   <Button label="Recover" class="p-button-sm" />
                   <router-link to="/ui/public/signin">
                       <Button label="Sign In" class="p-button-text p-button-sm"/>
                   </router-link>
               </div>
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
    name: "ForgotPassword",
    data(){
        return{
            email:null,
            code:null,
            new_password: null,
            confirm_password: null,
            code_sent:false
        }
    },
    methods:{
        sendCode(){
            this.code_sent = !this.code_sent
        }
    }
}
</script>

<style scoped>

</style>
