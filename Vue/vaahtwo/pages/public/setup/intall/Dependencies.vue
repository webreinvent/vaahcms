<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });

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
    <div
        v-if="store.assets"
        class="pt-4"
    >
        <Message severity="info" :closable="true" class="vc-dense"
                 :pt="{
                      root: {
                        class: 'mt-0'
                      },
                      text: {
                               'data-testid': `dependencies-message_text`
                             },
                      closebutton:{
                          'data-testid': `dependencies-message_close_btn`,
                      }
                  }">
            This step will install dependencies.
        </Message>
        <div class="grid" v-if="store.config.dependencies">
            <div class="col-12 md:col-6"
                 v-for="item in store.config.dependencies">
                <Card
                    :pt="{
                        content: {
                            class: 'pt-3 pb-0'
                        }
                    }"
                >
                    <template #title>
                        <div class="flex align-items-center justify-content-between">
                            <!-- UT-129 (UAT sweep) — the dependency card title
                                 was an <h5>: a level skip under the wizard's
                                 <h1>, and its UA size (0.83em = 11.6px at the
                                 14px root) was below the 12px floor of the
                                 type scale. It is now an <h2> at 14px. -->
                            <h2 class="font-semibold vc-text-14"
                                data-testid="dependencies-module_title">{{item.name}}</h2>
                            <i v-if="item.installed"
                               class="pi pi-check vc-icon-success p-2 border-round-3xl"
                               style="font-size: 12px"></i>
                            <i v-else class="pi pi-download vc-icon-neutral p-2 border-round-3xl"
                               style="font-size: 12px"></i>
                        </div>
                    </template>
                    <template #content class="pt-4 pb-0">
                        <div class="mb-3">
                            <Tag :value="item.type" class="mr-2" severity="secondary"></Tag>
                            <Tag :value="item.slug" class="mr-2" severity="secondary"></Tag>
                            <Tag :value="item.version" class="mr-2" severity="secondary"></Tag>
                        </div>
                        <p class="vc-text-13 vc-muted">
                            {{item.title}}
                        </p>
                        <p class="vc-text-13 mb-3">
                            Developed by:
                            <a target="_blank" :href="item.author_website">
                                {{item.author_name}}
                            </a>
                        </p>
                        <ProgressBar v-if="store.active_dependency && item.slug === store.active_dependency.slug "
                                     mode="indeterminate" class="mb-3"
                                     data-testid="dependencies-module_install_progressbar_active"/>
                        <ProgressBar v-else :value="0" class="mb-3"
                                     data-testid="dependencies-module_install_progressbar"/>
                        <div class="field-checkbox mb-0">
                            <Checkbox inputId="binary" v-model="item.import_sample_data"
                                      :binary="true" class="vc-dense"
                                      :pt="{
                                       hiddeninput: {
                                           'data-testid': `dependencies-select_module`
                                          }
                                     }"/>
                            <label for="binary" class="vc-text-13">Import Sample data</label>
                        </div>
                    </template>
                </Card>
            </div>
            <div class="col-12">
                <ProgressBar :value="store.config.count_installed_progress" class="mt-2"
                             data-testid="dependencies-install_progressbar"/>
                <div class="my-3">
                    <Button size="small" v-if="store.config.count_installed_progress === 100" icon="pi pi-check" @click="store.installDependencies()" :loading="store.is_btn_loading_dependency" label="Download & install Dependencies" class="p-button-success mr-2 vc-dense" data-testid="dependencies-install_dependencies_installed" :pt="{ label: { 'data-testid': `dependencies-install_dependencies_btn_text` } }"/>
                    <Button size="small" v-else icon="pi pi-download" @click="store.installDependencies()" :loading="store.is_btn_loading_dependency" label="Download & install Dependencies" class=" mr-2 vc-dense" outlined severity="info" data-testid="dependencies-install_dependencies" :pt="{ label: { 'data-testid': `dependencies-install_dependencies_btn_text` } }"/>

                    <Button size="small" label="Skip" @click="store.skipDependencies()" class="btn-dark vc-dense" outlined severity="info" data-testid="dependencies-skip" :pt="{ label: { 'data-testid': `dependencies-skip_btn_text` } }"/>
                </div>
            </div>
            <div class="col-12">
                <div class="flex justify-content-between">
                    <Button size="small" label="Back" class="" @click="$router.push({name:'setup.install.migrate'})" data-testid="dependencies-back_btn" :pt="{ label: { 'data-testid': `dependencies-back_btn_text` } }">
                    </Button>
                    <Button size="small" label="Save & Next" class="vaah-btn-primary" @click="store.validateDependencies" data-testid="dependencies-save_btn" :pt="{ label: { 'data-testid': `dependencies-save_btn_text` } }">
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
