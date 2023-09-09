<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';
import draggable from 'vuedraggable';
import { vaah } from '../../../vaahvue/pinia/vaah'
import {useUpdateStore} from "../../../stores/settings/store-update";
const store = useUpdateStore();
const route = useRoute();
const root = useRootStore();
import { useConfirm } from "primevue/useconfirm";
import {useRootStore} from "../../../stores/root";

const confirm = useConfirm();
onMounted(async () => {

    /**
     * fetch assets required for the crud
     * operation
     */
    await store.setPageTitle();
    // await store.getAssets();

});
</script>
<template>
    <Panel class="is-small">
        <template class="p-1" #header>
            <div class="flex flex-row">
                <div>
                    <b class="mr-1">Update VaahCMS</b>
                </div>
            </div>
        </template>

        <template #icons>
            <div class="buttons">
                <Button icon="pi pi-refresh"
                        label="Check for Update"
                        data-testid="setting-update_check"
                        @click="store.checkForUpdate"
                        class="p-button-sm"></Button>
            </div>
        </template>
        <Message
            severity="primary" :closable="false" class="text-center pt-3 pb-1">
            <p><i class="pi pi-bell" style="font-size: 1.5rem"></i></p>
            <div class="text-center" v-if="root.assets
                            && root.assets.vaahcms
                            && root.assets.vaahcms.version">
                <p>Current Version of <strong>VaahCMS</strong> is</p>
                <Button :label="root.assets.vaahcms.version"
                        data-testid="setting-notification_add_sms"

                        class="w-auto my-2 p-button-sm"
                />
                <p v-if="store.is_up_to_data"><span class="subtitle">Current version of this VaahCMS is the latest version</span></p>
            </div>
        </Message>

        <div v-if="store.backend_update">
            <div v-if="store.release" class="text-sm">
                <Message class="py-2" icon="pi-sync pi"
                    severity="success" :closable="false">
                    <p>A newer version <b>{{ store.remote_version }}</b> of VaahCMS is available.</p>
                </Message>

                <Panel class="is-small">
                    <template class="p-1" #header>
                        <div class="flex flex-row">
                            <div>
                                <b class="mr-1">NEW Updates:</b>
                            </div>
                        </div>
                    </template>
                    <div style="white-space: break-spaces;">
                        {{store.release.body}}
                    </div>
                    <div class="field-checkbox mt-3">
                        <Checkbox inputId="binary"
                                  v-model="store.backup_database"
                                  data-testid="setting-update_confirmation"
                                  @input="store.is_button_active = true"
                                  :binary="true"
                                  class="is-small"/>
                        <label for="binary">Have you taken the backup of your files & database?</label>
                    </div>
                    <Button label="Update Now"
                            :disabled="!store.is_button_active"
                            data-testid="setting-update_button"
                            @click="store.onUpdate"
                            class="p-button-sm mt-0 mb-3"></Button>
                    <div class="grid m-0" v-if="store.is_update_step_visible">
                        <div class="col-3">
                            <ol class="pl-3">
                                <li class="mb-2">
                                    Downloading latest version (it can take upto 3 to 5 minutes)
                                    <i v-if="store.status.download_latest_version === 'success'"
                                       class="pi pi-check"></i>
                                    <i v-else-if="store.status.download_latest_version === 'pending'"
                                       class="pi pi-spin pi-spinner"></i>
                                    <i v-else-if="store.status.download_latest_version === 'failed'"
                                       class="pi pi-times"></i>
                                </li>
                                <li class="mb-2">
                                    Publish assets
                                    <i v-if="store.status.publish_assets === 'success'"
                                       class="pi pi-check"></i>
                                    <i v-else-if="store.status.publish_assets === 'pending'"
                                       class="pi pi-spin pi-spinner"></i>
                                    <i v-else-if="store.status.publish_assets === 'failed'"
                                       class="pi pi-times"></i>
                                </li>
                                <li class="mb-2">
                                    Run migrations and seeds
                                    <i v-if="store.status.migration_and_seeds === 'success'"
                                       class="pi pi-check"></i>
                                    <i v-else-if="store.status.migration_and_seeds === 'pending'"
                                       class="pi pi-spin pi-spinner"></i>
                                    <i v-else-if="store.status.migration_and_seeds === 'failed'"
                                       class="pi pi-times"></i>
                                </li>
                                <li>
                                    Clear cache
                                    <i v-if="store.status.clear_cache === 'success'"
                                       class="pi pi-check"></i>
                                    <i v-else-if="store.status.clear_cache === 'pending'"
                                       class="pi pi-spin pi-spinner"></i>
                                    <i v-else-if="store.status.clear_cache === 'failed'"
                                       class="pi pi-times"></i>
                                </li>
                            </ol>
                            <Button label="Reload"
                                    icon="pi pi-refresh"
                                    @click="store.reloadPage()"
                                    data-testid="setting-update_refresh"
                                    class="p-button-sm p-button-success mt-3"></Button>
                        </div>
                        <div class="col-9">
                            <div id="terminal"></div>
                            <!--                            <Terminal welcomeMessage="Step 1/4 : Updating dependencies" prompt="primevue $" class="dark-demo-terminal" />-->
                        </div>
                    </div>
                </Panel>

            </div>
        </div>
        <div v-if="store.manual_update">
            <div v-if="store.release">
                A newer version <b>{{store.remote_version}}</b> of VaahCMS is available.
                This is a <b>major release</b>. You have to do manual upgrade to update VaahCms.
                <hr/>
                <b>New Updates:</b>
                <div class="content">

                    {{store.release.body}}
                </div>

                <b>Steps of Manually Upgrade</b>
                <ol class="ml-4">
                    <li>Go to Root path</li>
                    <li>Verify <b>version</b> of <b>webreinvent/vaahcms</b> in Composer.json</li>
                    <li>Run <b>Composer Update</b></li>
                    <li>Publish assets</li>
                    <li>Run Migrations and Seeds</li>
                    <li>Clear Cache</li>
                </ol>


            </div>
        </div>
    </Panel>

</template>

<style scoped lang="scss">
::v-deep(.dark-demo-terminal) {
    background-color: #212121;
    color: #ffffff;

    .p-terminal-command {
        color: #80CBC4;
    }

    .p-terminal-prompt {
        color: #FFD54F;
    }

    .p-terminal-response {
        color: #9FA8DA;
    }
}
</style>
<style>
.subtitle{
    color: #48c774!important;
    font-size: 1.25rem;
    font-weight: 400;
    line-height: 1.25;
    word-break: break-word;
    font-style: inherit;
}
</style>
