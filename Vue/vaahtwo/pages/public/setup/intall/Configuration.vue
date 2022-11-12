<script setup>

import {onMounted, reactive} from "vue";

import { useSetupStore } from '../../../../stores/setup'
const store = useSetupStore();
import { useRootStore } from '../../../../stores/root'
const root = useRootStore();


onMounted(async () => {
    await store.getAssets();
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
                     class="p-inputtext-sm" id="app-name"/>

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

    <Button v-if="store.config.env.db_is_valid"
            @click="store.testDatabaseConnection()"
            label="Test Database connection"
            :loading="store.is_btn_loading_db_connection"
            icon="pi pi-check"
            class="p-button-success p-button-sm my-4 is-small"/>

    <Button v-else
            @click="store.testDatabaseConnection()"
            label="Test Database connection"
            :loading="store.is_btn_loading_db_connection"
            icon="pi pi-database" class="p-button-sm my-4 is-small"/>



    <div class="grid p-fluid">
      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Provider</h5>
        <div class="p-inputgroup">
          <Dropdown v-model="store.config.env.mail_provider"
                    :options="store.assets.mail_sample_settings"
                    @change="store.setMailConfigurations()"
                    optionLabel="name" optionValue="slug"
                    placeholder="Select Mail Provider"
                    class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Driver</h5>
        <div class="p-inputgroup">
          <InputText v-model="store.config.env.mail_driver"
                     placeholder="Mail Driver" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Host</h5>
        <div class="p-inputgroup">
          <InputText v-model="store.config.env.mail_host"
                     placeholder="Mail Host" class="p-inputtext-sm"/>
        </div>
      </div>
    </div>

    <div class="grid p-fluid">
      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Port</h5>
        <div class="p-inputgroup">
            <InputText v-model="store.config.env.mail_port"
                       placeholder="Mail Port" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Username</h5>
        <div class="p-inputgroup">
          <InputText v-model="store.config.env.mail_username"
                     placeholder="Mail Username" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Password</h5>
        <div class="p-inputgroup">
          <Password v-model="store.config.env.mail_password"
                    :feedback="false" toggleMask
                    input-class="w-full p-inputtext-sm" placeholder="Mail Password"/>
        </div>
      </div>
    </div>

    <div class="grid p-fluid">
      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Encryption</h5>
        <div class="p-inputgroup">
          <Dropdown v-model="store.config.env.mail_encryption"
                    :options="store.assets.mail_encryption_types"
                    optionLabel="name" optionValue="slug"
                    placeholder="Select Mail Encryption" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">From Name</h5>
        <div class="p-inputgroup">
          <InputText v-model="store.config.env.mail_from_name"
                     placeholder="From Name" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">From Email</h5>
        <div class="p-inputgroup">
          <InputText v-model="store.config.env.mail_from_address"
                     placeholder="From Email" class="p-inputtext-sm"/>
        </div>
      </div>
    </div>

    <Button v-if="store.config.env.mail_is_valid"
            @click="$event => $refs.op.toggle($event)"
            label="Test Mail Configuration"
            icon="pi pi-check"
            class="p-button-success p-button-sm my-4 is-small"/>

    <Button v-else
            @click="$event => $refs.op.toggle($event)"
            label="Test Mail Configuration"
            icon="pi pi-envelope"
            class="p-button-sm my-4 is-small"/>


      <OverlayPanel ref="op" appendTo="body"
                    :showCloseIcon="true" id="overlay_panel"
                    style="width: 450px" :breakpoints="{'960px': '75vw'}">
          <div class="col-12">
              <h5 class="text-left p-1 title is-6">Mail Username</h5>
              <div class="p-inputgroup">
                  <InputText type="email" v-model="store.config.env.test_email_to"
                             placeholder="Your email" class="p-inputtext-sm"/>

              </div>
              <Button :loading="store.is_btn_loading_mail_config"
                      @click="store.testMailConfiguration"
                      label="Send Email"
                      class="p-button-sm my-4 is-small"/>
          </div>
      </OverlayPanel>

    <div class="grid p-fluid">
      <div class="col-12">
        <div class="flex justify-content-end">
          <Button label="Save & Next" :loading="store.is_btn_loading_config"
                  :disabled="!store.config.env.db_is_valid"
                  class="p-button-sm w-auto" @click="store.validateConfigurations"></Button>
        </div>
      </div>
    </div>

  </div>
</template>

<style scoped>

</style>
