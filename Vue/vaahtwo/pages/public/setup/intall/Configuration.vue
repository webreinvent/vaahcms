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
  <div v-if="store.assets" class="container">
    <h5 class="text-left p-1 title is-6">App URL</h5>

    <div class="grid p-fluid">
      <div class="col-12">
        <div class="p-input">
          <InputText v-model="store.config.env.app_url" disabled
                     placeholder="App URL" class="p-inputtext-sm"
                     id="app-url"/>

        </div>
      </div>
    </div>

    <div class="grid p-fluid">
      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">ENV</h5>
        <div class="p-inputgroup">

          <Dropdown v-model="store.config.env.app_env" :options="store.assets.environments"
                    @change="store.loadConfigurations()"
                    optionLabel="name" optionValue="slug"
                    placeholder="Select Env" class="p-inputtext-sm"/>

        </div>

          <InputText v-if="store.config.env.app_env == 'custom'"
                     v-model="store.config.env.app_env_custom"
                     placeholder="Env File Name" class="p-inputtext-sm"
                     id="app-env-custom"/>

      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Debug</h5>
        <div class="p-inputgroup">
          <Dropdown v-model="store.config.env.app_debug"
                    :options="store.debug_option" optionLabel="name"
                    optionValue="slug" placeholder="Select Debug"
                    class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Timezone</h5>
        <div class="p-inputgroup">
          <Dropdown v-model="store.config.env.app_timezone" :options="store.assets.timezones"
                    optionLabel="name" optionValue="slug" :filter="true"
                    placeholder="Select Timezone" class="p-inputtext-sm"/>
        </div>
      </div>
    </div>

    <div class="grid p-fluid">
      <div class="col-12">
    <h5 class="text-left p-1 title is-6">App/Website Name</h5>
        <div class="p-input">
          <InputText v-model="store.config.env.app_name"
                     placeholder="App/Website Name"
                     class="p-inputtext-sm" id="app-url"/>

        </div>
      </div>
    </div>

    <div class="grid p-fluid">
      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Database Type</h5>
        <div class="p-inputgroup">
          <Dropdown v-model="store.config.env.db_connection"
                    :options="store.assets.database_types"
                    optionLabel="name" optionValue="slug"
                    placeholder="Database Type" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Database Host</h5>
        <div class="p-inputgroup">
          <InputText v-model="store.config.env.db_host" placeholder="Database Host"
                     class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Database Port</h5>
        <div class="p-inputgroup">
          <InputText v-model="store.config.env.db_port" placeholder="Database Port"
                     class="p-inputtext-sm"/>
        </div>
      </div>
    </div>

    <div class="grid p-fluid">
      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Database Name</h5>
        <div class="p-inputgroup">
            <InputText v-model="store.config.env.db_database" placeholder="Database Name"
                       class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Database Username</h5>
        <div class="p-inputgroup">
          <InputText v-model="store.config.env.db_username"
                     placeholder="Database Username"
                     class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Database Password</h5>
        <div class="p-inputgroup">
          <Password v-model="store.config.env.db_password" :feedback="false"
                    toggleMask input-class="w-full p-inputtext-sm"
                    placeholder="Database Password"/>
        </div>
      </div>
    </div>

    <Button @click="store.testDatabaseConnection()" label="Test Database connection"
            :loading="store.is_btn_loading_db_connection"
            icon="pi pi-database" class="p-button-sm my-4 is-small"/>

    <div class="grid p-fluid">
      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Provider</h5>
        <div class="p-inputgroup">
          <Dropdown v-model="selectedCity1" :options="cities"
                    optionLabel="name" optionValue="code"
                    placeholder="Select Mail Provider"
                    class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Driver</h5>
        <div class="p-inputgroup">
          <InputText placeholder="Mail Driver" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Host</h5>
        <div class="p-inputgroup">
          <InputText placeholder="Mail Host" class="p-inputtext-sm"/>
        </div>
      </div>
    </div>

    <div class="grid p-fluid">
      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Port</h5>
        <div class="p-inputgroup">
          <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Mail Port" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Username</h5>
        <div class="p-inputgroup">
          <InputText placeholder="Mail Username" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Password</h5>
        <div class="p-inputgroup">
          <Password :feedback="false" toggleMask input-class="w-full p-inputtext-sm" placeholder="Mail Password"/>
        </div>
      </div>
    </div>

    <div class="grid p-fluid">
      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Encryption</h5>
        <div class="p-inputgroup">
          <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select Mail Encryption" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">From Name</h5>
        <div class="p-inputgroup">
          <InputText placeholder="From Name" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">From Email</h5>
        <div class="p-inputgroup">
          <InputText placeholder="From Email" class="p-inputtext-sm"/>
        </div>
      </div>
    </div>

    <Button label="Test Mail Configuration" icon="pi pi-envelope" class="p-button-sm my-4 is-small"/>

    <div class="grid p-fluid">
      <div class="col-12">
        <div class="flex justify-content-end">
          <Button label="Save & Next" class="p-button-sm w-auto" @click="goToNextStep"></Button>
        </div>
      </div>
    </div>

  </div>
</template>

<style scoped>

</style>
