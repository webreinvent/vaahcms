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

            <h4 class="text-xl font-semibold">Install VaahCMS</h4>
        </div>




        <ol class="flex items-center w-full text-sm font-medium text-center text-gray-500 dark:text-gray-400 sm:text-base">
            <li class="flex md:w-full items-center text-blue-600 dark:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
        <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
            </svg>
            Personal <span class="hidden sm:inline-flex sm:ms-2">Info</span>
        </span>
            </li>
            <li class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
        <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
            <span class="me-2">2</span>
            Account <span class="hidden sm:inline-flex sm:ms-2">Info</span>
        </span>
            </li>
            <li class="flex items-center">
                <span class="me-2">3</span>
                Confirmation
            </li>
        </ol>


        <div class="container vh-step relative">
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

