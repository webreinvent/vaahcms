<script setup>

import {onMounted, reactive} from "vue";

import { useSetupStore } from '../../../../stores/setup'
const store = useSetupStore();
import { useRootStore } from '../../../../stores/root'
import Footer from "../../../../components/organisms/Footer.vue"

const root = useRootStore();


onMounted(async () => {
    await store.getAssets();
    await store.getStatus();
});
</script>

<template>
    <div v-if="store && store.assets && root && root.assets" class="">
        <div class="text-center mb-4">
            <img :src="root.assets.backend_logo_url" alt="" class="mb-2 mx-auto h-3rem">
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
            <div class="w-auto text-center my-4"><Tag class="bg-black-alpha-90 m-auto is-small">
                ACTIVE ENV FILE: <b class="ml-1">{{ store.assets.env_file }}</b></Tag></div>
            <router-view />

            <Footer />
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
