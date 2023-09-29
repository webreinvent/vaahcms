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
        <div class="container vh-step">
            <Steps :model="store.install_items" class="my-4">
                <template #item="{item}">
                    <router-link :to="item.to">
                        <a class="flex align-items-center font-medium">
                            <i :class="item.icon" class="step-icon"></i>{{item.label}}</a>
                    </router-link>

                </template>
            </Steps>
            <div v-if="store.assets.env_file" class="w-auto text-center my-4">
                <Tag class="bg-black-alpha-90 m-auto is-small"
                     :pt="{
                      root: {
                               'data-testid': `setup-use_env`
                             }
                  }">
                ACTIVE ENV FILE: <b class="ml-1">{{ store.assets.env_file }}</b>
                </Tag>
            </div>
            <router-view />

            <Footer class="mt-3"/>
        </div>
    </div>
</template>

