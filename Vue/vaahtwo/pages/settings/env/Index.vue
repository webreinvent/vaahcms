<script setup>
import {onMounted} from "vue";
import {useRoute} from 'vue-router';

import {useEnvStore} from '../../../stores/settings/store-env'
import { useRootStore } from "../../../stores/root";

const root = useRootStore();
const store = useEnvStore();
const route = useRoute();

import { useConfirm } from "primevue/useconfirm";
const confirm = useConfirm();
onMounted(async () => {

    /**
     * fetch assets required for the crud
     * operation
     */
    await store.setPageTitle();
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
    <Panel class="is-small">
        <template class="p-1" #header>
            <div class="flex flex-row">
                <div>
                    <b class="mr-1">{{root.assets.language_string.env_variables.heading}}</b>
                </div>
            </div>
        </template>

        <template #icons>
            <div class="buttons">
                <Button
                        :label="root.assets.language_string.env_variables.download"
                        icon="pi pi-download"
                        class="p-button-sm mr-2"
                        data-testid="env-download_file"
                        @click="store.downloadFile(store.env_file)"

                />

                <Button icon="pi pi-refresh"
                        :label="root.assets.language_string.env_variables.refresh"
                        class="p-button-sm"
                        data-testid="env_refresh"
                        @click="store.sync"
                        :loading="store.is_btn_loading"
                />
            </div>
        </template>
        <div class="grid justify-content-start">
            <div class="col-12 md:col-6" v-for="(item,index) in store.list">
                <h5 class="p-1 text-xs mb-1">{{item.key}}</h5>
                <form>
                    <div class="p-inputgroup">
                        <password v-if="store.inputType(item) == 'password'"
                                  v-model="item.value"
                                  class="w-full"
                                  :disabled="store.isDisable(item)"
                                  toggleMask
                                  :auto-resize="true"
                                  :data-testid="'env-'+item.key"
                        />

                        <Textarea v-else
                                  v-model="item.value"
                                  rows="1"
                                  class="is-small"
                                  :disabled="store.isDisable(item)"
                                  :auto-resize="true"
                                  :data-testid="'env-'+item.key"
                        />

                        <Button icon="pi pi-copy"
                                :data-testid="'env-copy_'+item.key"
                                @click="store.getCopy(item)"
                        />

                        <Button icon="pi pi-trash"
                                class="p-button-danger p-button-sm"
                                :data-testid="'env-remove_'+item.key"
                                @click="store.removeVariable(item)"
                        />
                    </div>
                </form>
            </div>
        </div>

        <div class="grid justify-content-start mt-1">
            <div class="col-12 md:col-6">
                <div class="p-inputgroup">
                    <InputText :autoResize="true"
                               v-model="store.new_variable"
                               class="p-inputtext-sm"
                               :data-testid="'env-add_variable_field'"
                    />

                    <Button :label="root.assets.language_string.env_variables.add_env_variable_button"
                            :data-testid="'env-add_variable'"
                            icon="pi pi-plus"
                            @click="store.addVariable"
                            :disabled="!store.new_variable"
                            class="p-button-sm"
                    />
                </div>
            </div>

            <div class="col-12">
                <Divider class="mb-3 mt-0"/>
                <div class="p-inputgroup justify-content-end">
                    <Button :label="root.assets.language_string.env_variables.save_button"
                            icon="pi pi-save"
                            @click="store.confirmChanges"
                            :data-testid="'env-save_variable'"
                            class="p-button-sm"
                    />
                </div>
            </div>
        </div>
    </Panel>

</template>
