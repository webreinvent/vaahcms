<script setup>

import {onMounted, reactive} from "vue";

import { useSetupStore } from '../../../../stores/setup'
const store = useSetupStore();
import { useRootStore } from '../../../../stores/root'
const root = useRootStore();


onMounted(async () => {
    await store.getAssets();
    await store.getStatus();
});
</script>

<template>
    <div class="">
        <div class="text-center mb-4">
            <img src="http://irisrishu.com/vaahcms/backend/vaahone/images/vaahcms-logo.svg" alt="" class="w-1 mb-2 mx-auto">
            <h4 class="text-xl font-semibold">Install VaahCMS</h4>
        </div>
        <div class="container">
            <Steps :model="store.install_items" :readonly="false" class="my-4">
                <template #item="{item}">
                    <router-link :to="item.to">
                        <a class="flex align-items-center font-medium"> <i :class="item.icon" class="step-icon"></i>{{item.label}}</a>
                    </router-link>

                </template>
            </Steps>
            <div class="w-auto text-center my-4"><Tag class="bg-black-alpha-90 m-auto is-small">ACTIVE ENV FILE: <b class="ml-1">.env.rishu</b></Tag></div>
            <router-view />
            <div class="flex justify-content-center text-center mt-5">
                <div class="text-xs">
                    © 2022.<a class="px-1">VaahCMS</a> v1.6.6 | <a>Documentation</a>
                    <p class="text-xs">Laravel v8.4.1 | PHP v8.0.18</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.p-card .p-card-body {
    padding: 0.85rem 1rem;
}
.p-button{
    padding: 5px 8px;
}
.p-card .p-card-content {
    padding: 1rem 0 0 0;
}
</style>
