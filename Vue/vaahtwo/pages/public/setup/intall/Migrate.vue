<script setup>

import {onMounted, reactive} from "vue";

import { useConfirm } from "primevue/useconfirm";

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
        message: 'This will delete all existing migration from database/migrations folder.',
        icon: 'pi pi-exclamation-circle text-red-600',
        acceptClass:'p-button p-button-danger is-small',
        acceptLabel:'Proceed',
        rejectLabel:'Cancel',
        rejectClass:' is-small btn-dark',
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
        <Message severity="info" :closable="true" class="is-small"
                 :pt="{
                      text: {
                               'data-testid': `migrate-message_text`
                             },
                      closebutton:{
                          'data-testid': `migrate-message_close_btn`
                      }
                  }">
            This step will run database migrations and seeds.</Message>
        <Button v-if="store.config.is_migrated"
                label="Migrate & Run Seeds"
                icon="pi pi-check" iconPos="left"
                :loading="store.btn_is_migration"
                @click="confirmDelete" class="is-small" severity="success"
                data-testid="migrate-run_migration"/>
        <Button v-else label="Migrate & Run Seeds"
                icon="pi pi-database" iconPos="left"
                :loading="store.btn_is_migration"
                @click="confirmDelete" class="is-small" outlined
                data-testid="migrate-run_migration"
                :pt="{
                      label: {
                               'data-testid': `migrate-run_migration_btn_text`
                             }
                  }"/>
        <div class="flex justify-content-between mt-5">
            <Button label="Back" class="p-button-sm" severity="secondary"
                    @click="$router.push('/setup/install/configuration')"
                    data-testid="migrate-back_btn"
                    :pt="{
                      label: {
                               'data-testid': `migrate-back_btn_text`
                             }
                  }">
            </Button>
            <Button label="Save & Next"
                    class="p-button-sm"
                    @click="store.validateMigration"
                    data-testid="migrate-save_btn"
                    :pt="{
                      label: {
                               'data-testid': `migrate-save_btn_text`
                             }
                  }">
            </Button>
        </div>
        <ConfirmDialog group="templating" class="is-small"
                       :style="{width: '400px'}"
                       :breakpoints="{'600px': '100vw'}"
                       :pt="{
                           acceptbutton:{
                               root:{
                                   'data-testid': `migrate-confirmation_proceed_btn`
                               }

                           },
                           rejectbutton:{
                               root:{
                                   'data-testid': `migrate-confirmation_cancel_btn`
                               }

                           },
                           closeButton:{
                               'data-testid': `migrate-confirmation_close_btn`
                           },
                       }">
            <template #message="slotProps">
                <div class="flex">
                    <i :class="slotProps.message.icon" style="font-size: 1.5rem"></i>
                    <p class="pl-2 text-xs" data-testid="migrate-confirmation_message">{{slotProps.message.message}}</p>
                </div>
            </template>
        </ConfirmDialog>
    </div>
        </div>
        </div>
</template>

