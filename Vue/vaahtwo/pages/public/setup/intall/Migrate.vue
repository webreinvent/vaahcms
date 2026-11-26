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

import { useConfirm } from "openvue/useconfirm";

const confirm = useConfirm();

import { useSetupStore } from '../../../../stores/setup'
const store = useSetupStore();
import { useRootStore } from '../../../../stores/root'
import {useRoute} from "vue-router";
const root = useRootStore();
const route = useRoute();


onMounted(async () => {
    document.title = 'Migrate - Setup';
    await store.getAssets(route);
});



const confirmDelete = (event) => {
    confirm.require({
        group: 'templating',
        header: 'Deleting existing migrations',
        message: 'This will delete the existing VaahCMS migrations from the database/migrations folder. Migrations published by other packages are not affected.',
        // M6-T5 — the icon was a palette literal (`text-red-600`), which
        // does not flip in dark mode. The colour is the view's decision,
        // not the icon name's (reference-ui-conformance.md §3): the
        // payload keeps the icon name and the danger tone is applied
        // where the icon is rendered.
        icon: 'pi pi-exclamation-circle',
        // UT-129 - the confirm dialog's buttons are named through the v4
        // `acceptProps` / `rejectProps` contract, which the engine merges
        // onto the buttons it renders (so the attributes fall through to
        // the button root). The template's `:pt` could not carry them: the
        // ConfirmDialog's pt sections are `pcAcceptButton` / `pcRejectButton`
        // / `icon` / `message` — there is no `acceptbutton` / `rejectbutton`
        // / `closeButton` section, so every name in that block was silently
        // dropped and the buttons shipped with no locator at all.
        acceptProps: { class: 'p-button p-button-danger vc-dense', 'data-testid': 'migrate-confirmation_proceed_btn' },
        acceptLabel:'Proceed',
        rejectLabel:'Cancel',
        rejectProps: { class: 'vc-dense btn-dark', 'data-testid': 'migrate-confirmation_cancel_btn' },
        accept: () => {
            store.runMigrations();
        }
    });
};


</script>

<template>
    <div v-if="store.assets">
        <div class="p-card">
            <div class="p-card-content p-4 border-round-xl">
        <Message severity="info" :closable="true" class="vc-dense"
                 :pt="{
                      text: {
                               'data-testid': `migrate-message_text`
                             },
                      closebutton:{
                          'data-testid': `migrate-message_close_btn`,
                      }
                  }">
            This step will run database migrations and seeds.</Message>
        <Button v-if="store.status && store.status.is_db_migrated"
                label="Migrate & Run Seeds"
                icon="pi pi-check" iconPos="left"
                :loading="store.btn_is_migration"
                @click="confirmDelete" class="vc-dense"
                :pt="{
                      label: {
                               'data-testid': `migrate-run_migration_btn_text`
                             }
                  }"
                severity="success" data-testid="migrate-run_migration_migrated"/>
        <Button v-else label="Migrate & Run Seeds"
                icon="pi pi-database" iconPos="left"
                :loading="store.btn_is_migration"
                @click="confirmDelete" class="vc-dense"
                outlined severity="info"
                data-testid="migrate-run_migration"
                :pt="{
                      label: {
                               'data-testid': `migrate-run_migration_btn_text`
                             }
                  }"/>
        <div class="flex justify-content-between mt-5">
            <Button size="small" label="Back" class="" severity="secondary" @click="$router.push('/setup/install/configuration')" data-testid="migrate-back_btn" :pt="{ label: { 'data-testid': `migrate-back_btn_text` } }">
            </Button>
            <div class="flex align-items-center gap-2">
                <p class="vc-text-13">Migrate & Run Seeds for next step</p>
                <Button size="small" label="Save & Next" class="vaah-btn-primary" @click="store.validateMigration" data-testid="migrate-save_btn" :pt="{ label: { 'data-testid': `migrate-save_btn_text` } }">
                </Button>
            </div>
        </div>
        <ConfirmDialog group="templating" class="vc-dense"
                       :style="{width: '400px'}"
                       :breakpoints="{'600px': '100vw'}">
            <template #message="slotProps">
                <div class="flex">
                    <i :class="slotProps.message.icon" class="vc-danger-text" style="font-size: 1.5rem"></i>
                    <p class="pl-2 vc-text-14" data-testid="migrate-confirmation_message">{{slotProps.message.message}}</p>
                </div>
            </template>
        </ConfirmDialog>
    </div>
        </div>
        </div>
</template>

