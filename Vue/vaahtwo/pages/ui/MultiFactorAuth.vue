<template>
    <Card style="width: 28rem;max-width: 100vw; margin-bottom: 2em" class="m-auto">
        <template #title>
            <div class="content text-center">
                <img src="http://irisrishu.com/vaahcms/backend/vaahone/images/vaahcms-logo.svg" alt="" class="w-5 mb-2">
                <h4 class="vc-text-20 font-semibold line-height-2 mb-2">Multi-Factor Authentication</h4>
                <p class="vc-muted vc-text-13 font-semibold mb-4">You have received an email which contains two factor code.</p>
            </div>
        </template>
        <template #content>
            <FloatLabel class="mb-5">
                <InputText id="code" class="w-full"></InputText>
                <label for="code">Enter Code</label>
            </FloatLabel>
            <div class="field flex justify-content-between align-items-center">
                <Button size="small" label="Submit OTP" class="" />
                <router-link to="/public/forgot-password">
                    <Button size="small" label="Resend OTP in 10 secs.." class=""/>
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
    name: "MultiFactorAuth"
}
</script>

<style scoped>

</style>
