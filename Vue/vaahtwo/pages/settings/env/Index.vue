<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

import {useEnvStore} from '../../../stores/settings/store-env'

const store = useEnvStore();
const route = useRoute();

import { useConfirm } from "primevue/useconfirm";
const confirm = useConfirm();
onMounted(async () => {

    /**
     * fetch assets required for the crud
     * operation
     */
    await store.getAssets();

    /**
     * fetch list of records
     */
    await store.getList();

    /**
     * Change to upper case
     */
    await store.watchItem();
});
</script>

<template>
    <Card>
        <template #header>
            <div class="flex justify-content-between align-items-center">
                <div>
                    <h5 class="font-semibold text-lg inline mr-2">Environment Variables</h5>

                    <Tag class="mr-2">
                        <p class="font-semibold">{{store.env_file}}</p>
                    </Tag>
                </div>
                <div>
                    <Button icon="pi pi-download"
                            class="mr-2 p-button-sm"
                            data-testid="env-download_file"
                            @click="store.downloadFile(store.env_file)"
                    />

                    <Button icon="pi pi-refresh"
                            class="p-button-sm"
                            data-testid="-env-refresh"
                            @click="store.sync"
                            :loading="store.is_btn_loading"
                    />
                </div>
            </div>
        </template>

        <template #content>
            <div class="grid justify-content-start">
                <div class="col-12 md:col-6" v-for="(item,index) in store.list">
                    <h5 class="p-1 text-xs mb-1">{{item.key}}</h5>
                    <form>
                        <div class="p-inputgroup">
                            <password v-if="store.inputType(item) == 'password'"
                                      v-model="item.value"
                                      :disabled="store.isDisable(item)"
                                      toggleMask
                                      class="p-inputtext-sm"
                                      :data-testid="'env-'+item.key"
                            />

                            <InputText v-else
                                       v-model="item.value"
                                       :disabled="store.isDisable(item)"
                                       class="p-inputtext-sm"
                                       :data-testid="'env-'+item.key"
                            />

                            <Button icon="pi pi-copy"
                                    class="p-button-sm"
                                    :data-testid="'env-copy_+item.key'"
                                    @click="store.getCopy(item)"
                            />

                            <Button icon="pi pi-trash"
                                    class="p-button-danger p-button-sm"
                                    :data-testid="'env-remove_+item.key'"
                                    @click="store.removeVariable(item)"
                            />
                        </div>
                    </form>
                </div>
            </div>

            <div class="grid justify-content-start mt-5">
                <div class="col-12 md:col-6">
                    <div class="p-inputgroup">
                        <InputText :autoResize="true"
                                   v-model="store.new_variable"
                                   class="p-inputtext-sm"
                                   :data-testid="'env-add_variable_field'"
                        />

                        <Button label="Add Env Variable"
                                :data-testid="'env-add_variable'"
                                icon="pi pi-plus"
                                @click="store.addVariable"
                                :disabled="!store.new_variable"
                                class="p-button-sm"
                        />
                    </div>
                </div>

                <div class="col-12 md:col-6">
                    <div class="p-inputgroup justify-content-end">
                        <Button label="Save"
                                icon="pi pi-save"
                                @click="store.confirmChanges"
                                :data-testid="'env-save_variable'"
                                class="p-button-sm"
                        />
                    </div>
                </div>
            </div>
        </template>
    </Card>
</template>
