<script setup>
import {vaah} from '../vaahvue/pinia/vaah.js'
import {useRootStore} from '../stores/root.js'

import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";

const toast = useToast();
const confirm = useConfirm();
const useVaah = vaah();
const root = useRootStore();

useVaah.setToast(toast);
useVaah.setConfirm(confirm);
</script>


<template>
    <div  style="margin: 20px;">

        <ProgressBar style="z-index: 10000000; position: fixed; top: 1px; width: 100%; left: 0px; height: 2px;"
                     v-if="useVaah.show_progress_bar"
                     mode="indeterminate"/>

        <Toast class="p-container-toasts" position="top-center" >
            <template #message="slotProps">
                <div class="p-toast-message-text">
                    <span class="p-toast-summary" v-if="slotProps.message.summary"
                          v-html="slotProps.message.summary"></span>
                    <div class="p-toast-detail" v-if="slotProps.message.detail"
                         v-html="slotProps.message.detail">
                    </div>
                </div>

            </template>
        </Toast>

        <ConfirmDialog class="p-container-confirm-dialog"/>

        <RouterView />

    </div>
</template>
