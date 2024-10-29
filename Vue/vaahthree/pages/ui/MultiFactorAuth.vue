<template>
    <Card style="width: 28rem;max-width: 100vw; margin-bottom: 2em" class="m-auto">
        <template #title>
            <div class="content text-center">
                <img src="http://irisrishu.com/vaahcms/backend/vaahone/images/vaahcms-logo.svg" alt="" class="w-5 mb-2">
                <h4 class="text-xl font-semibold line-height-2 mb-2">Multi-Factor Authentication</h4>
                <p class="text-sm text-gray-600 font-semibold mb-4">You have received an email which contains two factor code.</p>
            </div>
        </template>
        <template #content>
            <div class="p-float-label mb-5">
                <InputText id="code" class="w-full"></InputText>
                <label for="code">Enter Code</label>
            </div>
            <div class="field flex justify-content-between align-items-center">
                <Button label="Submit OTP" class="p-button-sm" />
                <router-link to="/public/forgot-password">
                    <Button label="Resend OTP in 10 secs.." class="p-button-sm"/>
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
    name: "MultiFactorAuth"
}
</script>

<style scoped>

</style>
