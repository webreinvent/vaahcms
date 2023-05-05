<script setup>

import {onMounted, reactive} from "vue";

import { useConfirm } from "primevue/useconfirm";

const confirm = useConfirm();

import { useSetupStore } from '../../../../stores/setup'
const store = useSetupStore();
import { useRootStore } from '../../../../stores/root'
const root = useRootStore();


onMounted(async () => {
    document.title = 'Migrate - Setup';
    await store.getAssets();
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
        <Message severity="info" :closable="true" class="is-small">This step will run database migrations and seeds.</Message>
        <Button v-if="store.config.is_migrated"
                label="Migrate & Run Seeds"
                icon="pi pi-check" iconPos="left"
                :loading="store.btn_is_migration"
                @click="confirmDelete" class="p-button-success is-small"/>
        <Button v-else label="Migrate & Run Seeds"
                icon="pi pi-database" iconPos="left"
                :loading="store.btn_is_migration"
                @click="confirmDelete" class="is-small"/>
        <div class="flex justify-content-between mt-5">
            <Button label="Back" class="p-button-sm"
                    @click="$router.push('/setup/install/configuration')">
            </Button>
            <Button label="Save & Next"
                    class="p-button-sm"
                    @click="store.validateMigration">
            </Button>
        </div>
        <ConfirmDialog group="templating" class="is-small"
                       :style="{width: '400px'}"
                       :breakpoints="{'600px': '100vw'}">
            <template #message="slotProps">
                <div class="flex">
                    <i :class="slotProps.message.icon" style="font-size: 1.5rem"></i>
                    <p class="pl-2 text-xs">{{slotProps.message.message}}</p>
                </div>
            </template>
        </ConfirmDialog>
    </div>

</template>

<style scoped>

</style>
