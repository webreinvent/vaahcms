<script setup>

import {onMounted, reactive} from "vue";

import { useSetupStore } from '../../../../stores/setup'
const store = useSetupStore();
import { useRootStore } from '../../../../stores/root'
const root = useRootStore();


onMounted(async () => {
    await store.getAssets();
    store.getDependencies();
});

</script>
<template>
    <div v-if="store.assets">
        <Message severity="info" :closable="true" class="is-small">This step will install dependencies.</Message>
        <div class="grid" v-if="store.config.dependencies">
            <div class="col-12 md:col-6"
                 v-for="item in store.config.dependencies">
                <Card>
                    <template #title>
                        <div class="flex align-items-center justify-content-between">
                            <h5 class="font-semibold">{{item.name}}</h5>
                            <i class="pi pi-download bg-gray-200 p-2 border-round-3xl" style="font-size: 12px"></i>
                        </div>
                    </template>
                    <template #content>
                        <div class="mb-3">
                            <Tag :value="item.type" class="mr-2 bg-gray-200 text-black-alpha-80"></Tag>
                            <Tag :value="item.slug" class="mr-2 bg-gray-200 text-black-alpha-80"></Tag>
                            <Tag :value="item.version" class="mr-2 bg-gray-200 text-black-alpha-80"></Tag>
                        </div>
                        <p class="text-xs">
                            {{item.title}}
                        </p>
                        <p class="text-xs mb-3">
                            Developed by:
                            <a target="_blank" :href="item.author_website">
                                {{item.author_name}}
                            </a>
                        </p>
                        <ProgressBar :value="0" class="mb-3" />
                        <div class="field-checkbox">
                            <Checkbox inputId="binary" v-model="checked" :binary="true" class="is-small" />
                            <label for="binary" class="text-xs">Import Sample data</label>
                        </div>
                    </template>
                    <template #footer>
                        <Button icon="pi pi-check" label="Save" class="p-button-sm btn-primary-light is-small"/>
                        <Button icon="pi pi-times" label="Cancel" class="p-button-sm btn-danger-light is-small" style="margin-left: .5em" />
                    </template>
                </Card>
            </div>
            <div class="col-12">
                <ProgressBar :value="0" class="mt-4 mb-5" />
                <div class="my-3">
                    <Button icon="pi pi-download" label="Download & install Dependencies" class="p-button-sm mr-2 is-small"/>
                    <Button label="Skip" class="btn-dark p-button-sm is-small"/>
                </div>
            </div>
            <div class="col-12">
                <div class="flex justify-content-between">
                    <Button label="Back" class="p-button-sm" @click="goBack"></Button>
                    <Button label="Save & Next" class="p-button-sm" @click="goToNextStep"></Button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.p-progressbar{
  height: 8px;
}
</style>
