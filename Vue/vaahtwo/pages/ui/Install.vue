<template>
    <div class="">
        <div class="text-center mb-4">
            <img src="http://irisrishu.com/vaahcms/backend/vaahone/images/vaahcms-logo.svg" alt="" class="w-1 mb-2 mx-auto">
            <h4 class="text-xl font-semibold">Install VaahCMS</h4>
        </div>
        <div class="container">
            <Steps :model="items" :readonly="false" class="my-4">
                <template #item="{item}">
                    <router-link :to="item.to">
                        <a class="flex align-items-center font-medium"> <i :class="item.icon" class="step-icon"></i>{{item.label}}</a>
                    </router-link>

                </template>
            </Steps>
            <div class="w-auto text-center my-4"><Tag class="bg-black-alpha-90 m-auto is-small">ACTIVE ENV FILE: <b class="ml-1">.env.rishu</b></Tag></div>
            <router-view />
            <div class="flex justify-content-center text-center mt-5">
                <p class="text-xs">
                    © 2022.<a class="px-1">VaahCMS</a> v1.6.6 | <a>Documentation</a>
                    <p class="text-xs">Laravel v8.4.1 | PHP v8.0.18</p>
                </p>
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
                    to: '/public/install/configuration'
                },
                {
                    label: 'Migrate',
                    icon: 'pi pi-fw pi-database',
                    to: '/public/install/migrate'
                },
                {
                    label: 'Dependencies',
                    icon: 'pi pi-fw pi-server',
                    to: '/public/install/dependencies'
                },
                {
                    label: 'Account',
                    icon: 'pi pi-fw pi-user-plus',
                    to: '/public/install/account'
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

.step-icon{
    border: 2px solid #3273dc;
    border-radius: 100%;
    padding: 13px;
    position: relative;
    margin-right: 5px;
    &:before{
        position: absolute;
        left: 50%;
        top: 51%;
        transform: translate(-50%,-50%);
    }
}
.p-progressbar .p-progressbar-label{
    display: none;
}

.p-steps-item a .step-icon{
    background: #3273dc;
    color: white;
    padding:10px;
}
.p-steps-item a .step-icon:before{
    font-size: 0.675rem;
}

.p-steps-item.p-steps-current a .step-icon{
    background: #3273dc;
    color: white;
}
.p-steps-current ~ .p-steps-item a .step-icon{
    background: white;
    color: #b8daff;
    border-color: #b8daff;
}
.p-steps-current ~ .p-steps-item a{
    color: #b8daff;
}
.p-steps-item:last-child::before{
    display: none;
}
.p-steps-item a{
    position: relative;
    background: white;
    z-index: 99;
    padding: 0 3px;
    font-size: 0.85rem;
}
.p-steps .p-steps-item:before{
    border-color: #3273dc;
    border-width: 2px;
    top: 27px;
    width: 200px;
    left: 65%;
    z-index: -1;
}
.p-steps-current.p-steps-item:before{
    border-color: #b8daff;
}
.p-steps-current ~ .p-steps-item:before{
    border-color: #b8daff;
}

.p-confirm-dialog{
    &.is-small{
        .p-dialog-header{
            padding: 8px 12px;
            .p-dialog-title{
                font-size: 15px;
            }
        }
        .p-dialog-content{
            .p-confirm-dialog-icon{
                font-size: 20px;
            }
            .p-confirm-dialog-message{
                font-size: 13px;
                margin-left: 10px;
            }
        }
        .p-dialog-footer{
            padding: 10px;
        }
    }
}

//Message small
.p-message{
    &.is-small{
        .p-message-wrapper{
            padding:10px 15px;
            .p-message-text{
                font-size: 13px;
            }
            button{
                &.p-message-close{
                    justify-content: flex-end;
                    &:hover{
                        background:none;
                    }
                }
            }
        }
        .p-message-icon{
            font-size: 1rem;
        }
    }
}

</style>
