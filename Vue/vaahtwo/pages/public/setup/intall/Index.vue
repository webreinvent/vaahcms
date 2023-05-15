<script setup>

import {onMounted, reactive} from "vue";
import {useRoute} from 'vue-router';

import { useSetupStore } from '../../../../stores/setup'
const store = useSetupStore();
import { useRootStore } from '../../../../stores/root'
import Footer from "../../../../components/organisms/Footer.vue"

const root = useRootStore();
const route = useRoute();


onMounted(async () => {
    await store.getAssets();
    await store.getStatus();

});
</script>

<template>
    <div v-if="store && store.assets && root && root.assets" class="">
        <div class="text-center mb-4">
            <img v-if="root.assets.backend_logo_url"
                 :src="root.assets.backend_logo_url" alt=""
                 class="mb-2 mx-auto h-3rem">
            <h4 class="text-xl font-semibold">Install VaahCMS</h4>
        </div>
        <div class="container">
            <Steps :model="store.install_items" class="my-4">
                <template #item="{item}">
                    <router-link :to="item.to">
                        <a class="flex align-items-center font-medium">
                            <i :class="item.icon" class="step-icon"></i>{{item.label}}</a>
                    </router-link>

                </template>
            </Steps>
            <div v-if="store.assets.env_file" class="w-auto text-center my-4">
                <Tag class="bg-black-alpha-90 m-auto is-small">
                ACTIVE ENV FILE: <b class="ml-1">{{ store.assets.env_file }}</b>
                </Tag>
            </div>
            <router-view />

            <Footer />
        </div>
    </div>
</template>

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
    color: #3273dc;
    padding: 0 3px;
    font-size: 0.85rem;
}
.p-steps .p-steps-item:before{
    border-color: #3273dc;
    border-width: 2px;
    top: 27px;
    width: 220px;
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
