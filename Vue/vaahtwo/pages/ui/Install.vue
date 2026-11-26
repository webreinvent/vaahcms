<template>
    <div class="">
        <div class="text-center mb-4">
            <img src="http://irisrishu.com/vaahcms/backend/vaahone/images/vaahcms-logo.svg" alt="" class="w-1 mb-2 mx-auto">
            <h4 class="vc-text-20 font-semibold">Install VaahCMS</h4>
        </div>
        <div class="container">
            <Stepper class="my-4">
                <StepList>
                    <StepItem v-for="(item, i) in items" :value="i" :key="i">
                        <Step :value="i">
                            <router-link :to="item.to">
                                <a class="flex align-items-center font-medium"> <i :class="item.icon" class="step-icon"></i>{{item.label}}</a>
                            </router-link>
                        </Step>
                    </StepItem>
                </StepList>
            </Stepper>
            <div class="w-auto text-center my-4"><Tag class="bg-black-alpha-90 m-auto vc-dense">ACTIVE ENV FILE: <b class="ml-1">.env.rishu</b></Tag></div>
            <router-view />
            <div class="flex justify-content-center text-center mt-5">
                <div class="vc-text-12">
                    © 2022.<a class="px-1">VaahCMS</a> v1.6.6 | <a>Documentation</a>
                    <p class="vc-text-12">Laravel v8.4.1 | PHP v8.0.18</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "Install",
    data(){
        return{
            items: [
                {
                    label: 'Configuration',
                    icon: 'pi pi-fw pi-cog',
                    to: '/ui/public/install/configuration'
                },
                {
                    label: 'Migrate',
                    icon: 'pi pi-fw pi-database',
                    to: '/ui/public/install/migrate'
                },
                {
                    label: 'Dependencies',
                    icon: 'pi pi-fw pi-server',
                    to: '/ui/public/install/dependencies'
                },
                {
                    label: 'Account',
                    icon: 'pi pi-fw pi-user-plus',
                    to: '/ui/public/install/account'
                }
            ],
            formObject: {}
        }
    },
    methods: {
        nextPage(event) {
            for (let field in event.formData) {
                this.formObject[field] = event.formData[field];
            }
            console.log(this.items[event.pageIndex + 1].to);
            this.$router.push({path:this.items[event.pageIndex + 1].to});
        },
        prevPage(event) {
            this.$router.push(this.items[event.pageIndex - 1].to);
        },
        complete() {
            this.$toast.add({severity:'success', summary:'Order submitted', detail: 'Dear, ' + this.formObject.firstname + ' ' + this.formObject.lastname + ' your order completed.'});
        }
    }
}
</script>

<style lang="scss">


</style>
