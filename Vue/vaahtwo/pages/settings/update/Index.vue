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
import { vaah } from '../../../vaahvue/pinia/vaah'
import {useUpdateStore} from "../../../stores/settings/store-update";
const store = useUpdateStore();
const route = useRoute();
const root = useRootStore();
import { useConfirm } from "openvue/useconfirm";
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
    <Panel class="vc-dense" v-if="root && root.assets">
        <template class="p-1" #header>
            <div class="flex flex-row">
                <div>
                    <!-- UT-130 — the page title was a <b>, so the screen had no
                         heading at all. The class list and the surrounding
                         markup are the general settings page's, verbatim. -->
                    <h1 class="mr-1 vaah-type-title">{{ root.assets.language_strings.update.heading_update_vaahcms }}</h1>
                </div>
            </div>
        </template>

        <template #icons>
            <div class="buttons">
                <Button size="small" icon="pi pi-refresh" :label="root.assets.language_strings.update.check_for_update_button" data-testid="setting-update_check" @click="store.checkForUpdate" class=""></Button>
            </div>
        </template>
        <Message
            severity="info" :closable="false" class="text-center pt-1">
            <p class="text-center"><i class="pi pi-bell" style="font-size: 1.2rem"></i></p>
            <div class="text-center" v-if="root.assets
                            && root.assets.vaahcms
                            && root.assets.vaahcms.version">
                <p v-html="root.assets.language_strings.update.current_version_of_vaahcms_is"></p>
                <Button size="small" :label="root.assets.vaahcms.version" data-testid="setting-notification_add_sms" class="w-auto my-2" />
                <p v-if="store.is_up_to_data"><span class="subtitle">{{root.assets.language_strings.update.check_for_update_message}}</span></p>
            </div>
        </Message>

        <div v-if="store.backend_update">
            <div v-if="store.release" class="vaah-type-body">
                <Message class="py-2" icon="pi-sync pi"
                    severity="success" :closable="false">
                    <p>{{root.assets.language_strings.update.a_newer_version}}<b>{{ store.remote_version }}</b> {{root.assets.language_strings.update.of_vaahcms_is_available}}</p>
                </Message>

                <Panel class="vc-dense">
                    <template class="p-1" #header>
                        <div class="flex flex-row">
                            <div>
                                <b class="mr-1 vaah-type-section">{{root.assets.language_strings.update.new_updates}}:</b>
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
                                  class="vc-dense"/>
                        <label for="binary">{{root.assets.language_strings.update.new_updates_message}}</label>
                    </div>
                    <Button size="small" label="Update Now" :disabled="!store.is_button_active" data-testid="setting-update_button" @click="store.onUpdate" class=" mt-0 mb-3"></Button>
                    <div class="grid m-0" v-if="store.is_update_step_visible">
                        <div class="col-3">
                            <ol class="pl-3">
                                <li class="mb-2">
                                    {{root.assets.language_strings.update.downloading_latest_version}}
                                    <i v-if="store.status.download_latest_version === 'success'"
                                       class="pi pi-check"></i>
                                    <i v-else-if="store.status.download_latest_version === 'pending'"
                                       class="pi pi-spin pi-spinner"></i>
                                    <i v-else-if="store.status.download_latest_version === 'failed'"
                                       class="pi pi-times"></i>
                                </li>
                                <li class="mb-2">
                                    {{ root.assets.language_strings.update.update_publish_assets }}
                                    <i v-if="store.status.publish_assets === 'success'"
                                       class="pi pi-check"></i>
                                    <i v-else-if="store.status.publish_assets === 'pending'"
                                       class="pi pi-spin pi-spinner"></i>
                                    <i v-else-if="store.status.publish_assets === 'failed'"
                                       class="pi pi-times"></i>
                                </li>
                                <li class="mb-2">
                                    {{ root.assets.language_strings.update.run_migrations_and_seeds }}
                                    <i v-if="store.status.migration_and_seeds === 'success'"
                                       class="pi pi-check"></i>
                                    <i v-else-if="store.status.migration_and_seeds === 'pending'"
                                       class="pi pi-spin pi-spinner"></i>
                                    <i v-else-if="store.status.migration_and_seeds === 'failed'"
                                       class="pi pi-times"></i>
                                </li>
                                <li>
                                    {{ root.assets.language_strings.update.clear_cache_button }}
                                    <i v-if="store.status.clear_cache === 'success'"
                                       class="pi pi-check"></i>
                                    <i v-else-if="store.status.clear_cache === 'pending'"
                                       class="pi pi-spin pi-spinner"></i>
                                    <i v-else-if="store.status.clear_cache === 'failed'"
                                       class="pi pi-times"></i>
                                </li>
                            </ol>
                            <Button size="small" :label="root.assets.language_strings.update.reload_button" icon="pi pi-refresh" @click="store.reloadPage()" data-testid="setting-update_refresh" class=" p-button-success mt-3"></Button>
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
                {{ root.assets.language_strings.update.a_newer_version }} <b>{{store.remote_version}}</b> {{ root.assets.language_strings.update.of_vaahcms_is_available }}
                {{ root.assets.language_strings.update.major_release_message }}
                <hr/>
                <b>New Updates:</b>
                <div class="content">

                    {{store.release.body}}
                </div>

                <b>{{ root.assets.language_strings.update.steps_of_manually_upgrade }}</b>
                <ol class="ml-4">
                    <li>{{ root.assets.language_strings.update.go_to_root_path }}</li>
                    <li v-html="root.assets.language_strings.update.verify_version_in_composer_json"></li>
                    <li v-html="root.assets.language_strings.update.run_composer_update"></li>
                    <li>{{ root.assets.language_strings.update.update_publish_assets }}</li>
                    <li>{{ root.assets.language_strings.update.run_migrations_and_seeds }}</li>
                    <li>{{ root.assets.language_strings.update.clear_cache_button }}</li>
                </ol>


            </div>
        </div>
    </Panel>

</template>

<style scoped lang="scss">
/* M6-T4 (F23) — the terminal demo styles carried six literal hexes.
   A terminal is a CODE surface, not a page surface: it stays dark in both
   schemes, so its roles bind to the fixed neutral ramp (surface.900 for
   the fill, surface.100 for the body text) and to the palette's own light
   steps — never to a scheme-flipping semantic role, and never to a
   literal colour. */
::v-deep(.dark-demo-terminal) {
    background-color: var(--p-surface-900);
    color: var(--p-surface-100);

    .p-terminal-command {
        color: var(--p-blue-300);
    }

    .p-terminal-prompt {
        color: var(--p-amber-300);
    }

    .p-terminal-response {
        color: var(--p-indigo-300);
    }
}
</style>
<style>
/* M6-T4 (F23) — "Current version of this VaahCMS is the latest version"
   is a SUCCESS statement, so it wears the success tone — a semantic token
   that flips with the scheme (#15803d light / #4ade80 dark) instead of the
   literal #48c774 it carried. Its size was 1.25rem = 17.5px at the 14px
   root, which is off the DESIGN-SYSTEM.md §6 scale; the message body copy
   is 13px (secondary), one step down from the 14px body. */
.subtitle{
    color: var(--p-button-success-background)!important;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.5;
    word-break: break-word;
    font-style: inherit;
}
</style>
