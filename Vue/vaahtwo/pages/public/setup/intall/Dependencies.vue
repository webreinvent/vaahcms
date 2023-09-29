<script setup>

import {onMounted, reactive} from "vue";

import { useSetupStore } from '../../../../stores/setup'
const store = useSetupStore();
import { useRootStore } from '../../../../stores/root'
const root = useRootStore();


onMounted(async () => {
    document.title = 'Dependencies - Setup';
    await store.getAssets();
    store.getDependencies();
});

</script>
<template>
    <div v-if="store.assets">
        <Message severity="info" :closable="true" class="is-small"
                 :pt="{
                      text: {
                               'data-testid': `dependencies-message_text`
                             },
                      closebutton:{
                          'data-testid': `dependencies-message_close_btn`
                      }
                  }">
            This step will install dependencies.
        </Message>
        <div class="grid" v-if="store.config.dependencies">
            <div class="col-12 md:col-6"
                 v-for="item in store.config.dependencies">
                <Card>
                    <template #title>
                        <div class="flex align-items-center justify-content-between">
                            <h5 class="font-semibold"
                                data-testid="dependencies-module_title">{{item.name}}</h5>
                            <i v-if="item.installed"
                               class="pi pi-check bg-green-500 p-2 border-round-3xl"
                               style="font-size: 12px"></i>
                            <i v-else class="pi pi-download bg-gray-200 p-2 border-round-3xl"
                               style="font-size: 12px"></i>
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
                        <ProgressBar v-if="store.active_dependency && item.slug === store.active_dependency.slug "
                                     mode="indeterminate" class="mb-3"
                                     data-testid="dependencies-module_install_progressbar"/>
                        <ProgressBar v-else :value="0" class="mb-3"
                                     data-testid="dependencies-module_install_progressbar"/>
                        <div class="field-checkbox">
                            <Checkbox inputId="binary" v-model="item.import_sample_data"
                                      :binary="true" class="is-small"
                                      :pt="{
                                       hiddeninput: {
                                           'data-testid': `dependencies-select_module`
                                          }
                                     }"/>
                            <label for="binary" class="text-xs">Import Sample data</label>
                        </div>
                    </template>
                </Card>
            </div>
            <div class="col-12">
                <ProgressBar :value="store.config.count_installed_progress" class="mt-4 mb-5"
                             data-testid="dependencies-install_progressbar"/>
                <div class="my-3">
                    <Button v-if="store.config.count_installed_progress === 100"
                            icon="pi pi-check"
                            @click="store.installDependencies()"
                            :loading="store.is_btn_loading_dependency"
                            label="Download & install Dependencies"
                            class="p-button-success p-button-sm mr-2 is-small"
                            data-testid="dependencies-install_dependencies"
                            :pt="{
                                 label: {
                                      'data-testid': `dependencies-install_dependencies_btn_text`
                                      }
                                  }"/>
                    <Button v-else icon="pi pi-download"
                            @click="store.installDependencies()"
                            :loading="store.is_btn_loading_dependency"
                            label="Download & install Dependencies"
                            class="p-button-sm mr-2 is-small"
                            data-testid="dependencies-install_dependencies"
                            :pt="{
                                 label: {
                                      'data-testid': `dependencies-install_dependencies_btn_text`
                                      }
                                  }"/>

                    <Button label="Skip"
                            @click="store.skipDependencies()"
                            class="btn-dark p-button-sm is-small"
                            data-testid="dependencies-skip"
                            :pt="{
                                 label: {
                                      'data-testid': `dependencies-skip_btn_text`
                                      }
                                  }"/>
                </div>
            </div>
            <div class="col-12">
                <div class="flex justify-content-between">
                    <Button label="Back" class="p-button-sm"
                            @click="$router.push({name:'setup.install.migrate'})"
                            data-testid="dependencies-back_btn"
                            :pt="{
                      label: {
                               'data-testid': `dependencies-back_btn_text`
                             }
                  }">
                    </Button>
                    <Button label="Save & Next"
                            class="p-button-sm" @click="store.validateDependencies"
                            data-testid="dependencies-save_btn"
                            :pt="{
                      label: {
                               'data-testid': `dependencies-save_btn_text`
                             }
                  }">
                    </Button>
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
