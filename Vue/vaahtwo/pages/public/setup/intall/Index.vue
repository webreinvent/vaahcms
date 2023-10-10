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
            <Steps
                :model="store.install_items"
                class="my-4"
            >
                <template #item="{item, index}">
                    <router-link :to="item.to" class="flex align-items-center font-medium">
                            <i :class="item.icon" class="step-icon"></i>
                            <span class="step-label">&nbsp;{{ index + 1 }}. {{item.label}}</span>
                    </router-link>
                </template>
            </Steps>
            <Tag v-if="store.assets.env_file"
                 class="vh-env-tag bg-black-alpha-70 m-auto is-small absolute"
                 :pt="{
                  root: {
                           'data-testid': `setup-use_env`
                        }
              }">
                <span class="font-medium">ACTIVE ENV FILE: </span>
                <b class="ml-1">{{ store.assets.env_file }}</b>
            </Tag>
            <router-view />

            <Footer class="mt-3"/>
        </div>
    </div>
</template>

