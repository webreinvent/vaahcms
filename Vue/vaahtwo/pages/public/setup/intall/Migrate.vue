<script setup>

import {onMounted, reactive} from "vue";

import { useSetupStore } from '../../../../stores/setup'
const store = useSetupStore();
import { useRootStore } from '../../../../stores/root'
const root = useRootStore();


onMounted(async () => {

});
</script>

<template>
  <Message severity="info" :closable="true" class="is-small">This step will run database migrations and seeds.</Message>
  <Button label="Migrate & Run Seeds" icon="pi pi-database" iconPos="left" @click="showTemplate" class="is-small"/>
  <div class="flex justify-content-between mt-5">
    <Button label="Back" class="p-button-sm" @click="$router.push('/setup/install/configuration')"></Button>
    <Button label="Save & Next" class="p-button-sm" @click="goToNextStep"></Button>
  </div>
  <ConfirmDialog group="templating" class="is-small" :style="{width: '400px'}" :breakpoints="{'600px': '100vw'}">
    <template #message="slotProps">
      <div class="flex">
        <i :class="slotProps.message.icon" style="font-size: 1.5rem"></i>
        <p class="pl-2 text-xs">{{slotProps.message.message}}</p>
      </div>
    </template>
  </ConfirmDialog>
</template>

<style scoped>

</style>
