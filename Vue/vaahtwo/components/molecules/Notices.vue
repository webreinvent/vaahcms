<script setup>
import {onMounted, reactive, ref} from "vue";

import { useRootStore } from '../../stores/root'

const root = useRootStore();

</script>

<template>
<!--    <div v-if="root &&-->
<!--    root.assets &&-->
<!--    root.assets.vue_notices &&-->
<!--    root.assets.vue_notices.length > 0" v-for="notice in root.assets.vue_notices">-->
<!--        <Message >-->
<!--            <span></span>-->
<!--            {{notice.meta.message}}-->
<!--            <Button :label="notice.meta.action.label"-->

<!--                    class="p-button-secondary"/>-->
<!--        </Message>-->
<!--    </div>-->

        <div v-if="root &&
        root.assets &&
        root.assets.vue_notices &&
        root.assets.vue_notices.length > 0" v-for="notice in root.assets.vue_notices">
            <div v-for="notice in root.assets.vue_notices">
                <div class="bg-blue-700 text-gray-100 flex justify-content-between mb-5 p-3">
<!--                    <div class="font-bold ml-1">🔥 Hot Deals!</div>-->
                    <div class="col-9 align-items-center hidden lg:flex ">
                        <span class="line-height-3 mr-2"><i class="pi pi-info-circle"></i></span>
                        <span class="line-height-3">{{notice.meta.message}}</span>
                    </div>
                    <div class="">
                        <Button :label="notice.meta.action.label"
                                data-testid="notice-goto_update"
                                @click="root.markAsRead(notice)"
                                class="p-button-raised p-button-primary mr-2"/>
                        <Button icon="pi pi-times-circle"
                                @click="root.markAsRead(notice,true)"
                                data-testid="notice-mark_as_read"
                                class="p-button-rounded p-button-text p-button-info"/>
                    </div>

                </div>
            </div>
        </div>

</template>
