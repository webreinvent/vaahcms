<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

import {useEnvStore} from '../../../stores/store-env'

const store = useEnvStore();
const route = useRoute();

import { useConfirm } from "primevue/useconfirm";
const confirm = useConfirm();
onMounted(async () => {
    /**
     * call onLoad action when List view loads
     */
    await store.onLoad(route);

    /**
     * watch routes to update view, column width
     * and get new item when routes get changed
     */
    await store.watchRoutes(route);

    /**
     * watch states like `query.filter` to
     * call specific actions if a state gets
     * changed
     */
    await store.watchStates();

    /**
     * fetch assets required for the crud
     * operation
     */
    await store.getAssets();

    /**
     * fetch list of records
     */
    await store.getList();
});
</script>

<template>
    <Card>
        <template #header>
            <div class="flex justify-content-between align-items-center">
                <div>
                    <h5 class="font-semibold text-lg inline mr-2">Environment Variables</h5>
                    <Tag class="mr-2">
                        <p class="font-semibold">.env.rishu</p>
                    </Tag>
                </div>
                <div>
                    <Button icon="pi pi-download" class="mr-2 p-button-sm"/>
                    <Button icon="pi pi-refresh" class="p-button-sm"/>
                </div>
            </div>
        </template>
        <template #content>
            <div class="grid justify-content-start">
                <div class="col-12 md:col-6" v-for="(item,index) in store.list">
                    <h5 class="p-1 text-xs mb-1">{{item.name}}</h5>
                    <div class="p-inputgroup">
                        <Textarea :model-value="item.value" :autoResize="true" class="has-min-height"/>
                        <Button icon="pi pi-copy" class=" has-max-height"/>
                        <Button icon="pi pi-trash" class="p-button-danger has-max-height"/>
                    </div>
                </div>
            </div>
            <div class="grid justify-content-start mt-5">
                <div class="col-12 md:col-6">
                    <div class="p-inputgroup">
                        <InputText v-model="addEnvVariable" v-if="showEnvInput"></InputText>
                        <Button label="Add Env Variable" icon="pi pi-plus" @click="addLinkHandler"></Button>
                    </div>
                </div>
                <div class="col-12 md:col-6">
                    <div class="p-inputgroup justify-content-end">
                        <Button label="Save" icon="pi pi-save"></Button>
                    </div>
                </div>
            </div>
        </template>
    </Card>

</template>



<style scoped>

</style>
