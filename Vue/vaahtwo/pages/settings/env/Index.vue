<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

import {useEnvStore} from '../../../stores/settings/store-env'

const store = useEnvStore();
const route = useRoute();

import { useConfirm } from "openvue/useconfirm";
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
    <Panel class="vc-dense" v-if="store && store.assets">
        <template class="p-1" #header>
            <div class="flex flex-row">
                <div>
                    <h1 class="mr-1 vaah-type-title">{{ store.assets.language_strings.env_variable_heading }}</h1>
                </div>
            </div>
        </template>

        <template #icons>
            <div class="buttons">
                <Button size="small" :label="store.assets.language_strings.download" icon="pi pi-download" class=" mr-2" data-testid="env-download_file" @click="store.downloadFile(store.env_file)" />

                <Button size="small" icon="pi pi-refresh" :label="store.assets.language_strings.refresh" class="" data-testid="env_refresh" @click="store.sync" :loading="store.is_btn_loading" />
            </div>
        </template>
        <div class="grid mt-1">
            <div class="col-12 md:col-6" v-for="(item,index) in store.list">
                <div class="p-1 vaah-type-caption mb-1">{{item.key}}</div>
                <form>
                    <InputGroup>
                        <Password v-if="store.inputType(item) == 'password'"
                                  v-model="item.value"
                                  class="w-full"
                                  :disabled="store.isDisable(item)"
                                  toggleMask
                                  :inputProps="{
                                      autocomplete:'on',
                                      'aria-label': 'Value of ' + item.key
                                  }"
                                  :auto-resize="true"
                                  :data-testid="'env-'+item.key"
                        />

                        <Textarea v-else
                                  v-model="item.value"
                                  :aria-label="'Value of ' + item.key"
                                  rows="1"
                                  class="w-full vc-dense"
                                  :disabled="store.isDisable(item)"
                                  :auto-resize="true"
                                  style="min-height: 0"
                                  :data-testid="'env-'+item.key"
                        />

                        <Button icon="pi pi-copy" aria-label="Copy to clipboard"
                                :data-testid="'env-copy_'+item.key"
                                @click="store.getCopy(item)"
                        />

                        <Button size="small" icon="pi pi-trash" aria-label="Remove variable" class="p-button-danger" :data-testid="'env-remove_'+item.key" @click="store.removeVariable(item)" />
                    </InputGroup>
                </form>
            </div>
        </div>

        <div class="grid justify-content-start mt-1">
            <div class="col-12 md:col-6">
                <InputGroup>
                    <InputText :autoResize="true" v-model="store.new_variable" aria-label="New environment variable name" class="" :data-testid="'env-add_variable_field'" />

                    <Button size="small" :label="store.assets.language_strings.add_env_variable_button" :data-testid="'env-add_variable'" icon="pi pi-plus" @click="store.addVariable" :disabled="!store.new_variable" class="" />
                </InputGroup>
            </div>

            <div class="col-12">
                <Divider class="mb-3 mt-0"/>
                <InputGroup class="justify-content-end">
                    <Button size="small" :label="store.assets.language_strings.env_variable_save_button" icon="pi pi-save" @click="store.confirmChanges" :data-testid="'env-save_variable'" class="" />
                </InputGroup>
            </div>
        </div>
    </Panel>

</template>
