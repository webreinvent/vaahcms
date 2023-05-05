<template>
    <div class="setup text-center">
        <img src="http://irisrishu.com/vaahcms/backend/vaahone/images/vaahcms-logo.svg" alt="" class="w-1 mb-5">
        <div class="grid justify-content-center">
            <div class="col-12">
                <Message severity="success">VaahCMS is successfully setup</Message>
            </div>
            <div class="col-6">
                <Card>
                    <template #title>
                        <div class="flex justify-content-between align-items-center">
                            <h4 class="text-xl font-semi-bold">Install</h4>
                            <div class="icons flex">
                                <a class="m-1">
                                    <i class="bg-gray-200 p-2 border-round-3xl pi pi-server" v-tooltip.top="'Dashboard'"></i>
                                </a>
                                <a class="m-1">
                                    <i class="bg-gray-200 p-2 border-round-3xl pi pi-book" v-tooltip.top="'Documentation'"></i>
                                </a>
                            </div>
                        </div>
                    </template>
                    <template #content>
                        <p class="text-sm text-left">
                            <a href="https://vaah.dev/cms" target="_blank">VaahCMS</a> is a web application development platform shipped with headless content management system
                        </p>
                        <div class="flex justify-content-between align-items-center mt-4">
                            <Button label="Install" icon="pi pi-server" class="p-button-secondary p-button-outlined p-button-sm"/>
                            <SplitButton label="Advanced Options" :model="items" class="p-button-sm"></SplitButton>
                        </div>
                    </template>
                </Card>
            </div>
            <div class="col-6">
                <Card class="h-full">
                    <template #title>
                        <div class="flex justify-content-between align-items-center">
                            <h4 class="text-xl font-semi-bold">Reset</h4>
                            <div class="icons flex">
                                <div class="m-1">
                                    <a href="">
                                        <i class="bg-gray-200 p-2 border-round-3xl pi pi-refresh"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template #content>
                        <p class="text-sm text-left">
                            You can reset/re-install the application if you're logged in from "Administrator" account.
                        </p>
                        <div class="flex justify-content-between align-items-center mt-4">
                            <Button label="Reset" icon="pi pi-refresh" class="p-button-danger p-button-sm"/>
                        </div>
                    </template>
                </Card>
            </div>
        </div>
        <div class="text-xs text-center mt-8"><p>
            © 2022.
            <a class="text-blue-400" href="https://vaah.dev/cms" target="_blank">VaahCMS</a>
            v1.6.10
            | <a class="text-blue-400" href="https://docs.vaah.dev/vaahcms" target="_blank">Documentation</a></p> <p class="has-text-centered">
            Laravel v8.41.0
            | PHP v8.0.18
        </p></div>
    </div>
</template>

<script>
export default {
    name: "Setup",
    data(){
        return{
            items: [
                {
                    label: 'Publish assets'
                },
                {
                    label: 'Clear Cache'
                }
            ]
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
