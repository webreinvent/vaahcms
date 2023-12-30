<script setup>

import {onMounted, reactive} from "vue";

import { useSetupStore } from '../../../../stores/setup'
const store = useSetupStore();
import { useRootStore } from '../../../../stores/root'
const root = useRootStore();


onMounted(async () => {
    document.title = 'Configuration - Setup';
    store.config.env.app_timezone = root.assets.timezone;
    await store.getAssets();
    await store.getRequiredConfigurations();
});
</script>

<template>
  <div v-if="store.assets" class="container">
      <div class="p-card">
          <div class="p-card-content p-4 border-round-xl">
              <h5 class="text-left p-1 title is-6">App URL</h5>

              <div class="grid p-fluid">
                  <div class="col-12">
                      <div class="p-input">
                          <InputText v-model="store.config.env.app_url" disabled
                                     placeholder="App URL" class="p-inputtext-sm"
                                     id="app-url"
                                     data-testid="configuration-app_url"
                                     required
                          />
                          <div class="required-field hidden"></div>
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
                                    placeholder="Select Env" class="is-small"
                                    :inputProps="store.config.data_testid_app_env"
                                    required
                          />
                          <div class="required-field hidden"></div>
                      </div>

                      <InputText v-if="store.config.env.app_env == 'custom'"
                                 v-model="store.config.env.app_env_custom"
                                 placeholder="Env File Name" class="is-small"
                                 id="app-env-custom"
                                 data-testid="configuration-custom_evn"
                                 required
                      />
                      <div class="required-field hidden"></div>
                  </div>
                  <div class="col-12 md:col-4">
                      <h5 class="text-left p-1 title is-6">Debug</h5>
                      <div class="p-inputgroup">
                          <Dropdown v-model="store.config.env.app_debug"
                                    name="config-db_connection"
                                    :options="store.debug_option" optionLabel="name"
                                    optionValue="slug" placeholder="Select Debug"
                                    class="is-small"
                                    :inputProps="store.config.data_testid_debug"
                                    required
                          />
                          <div class="required-field hidden"></div>
                      </div>
                  </div>
                  <div class="col-12 md:col-4">
                      <h5 class="text-left p-1 title is-6">Timezone</h5>
                      <div class="p-inputgroup">
                          <Dropdown v-model="store.config.env.app_timezone"
                                    :options="store.assets.timezones"
                                    optionLabel="name" optionValue="slug" :filter="true"
                                    placeholder="Select Timezone" class="is-small"
                                    :inputProps="store.config.data_testid_timezone"
                                    required
                          />
                          <div class="required-field hidden"></div>
                      </div>
                  </div>
              </div>
              <div class="grid p-fluid">
                  <div class="col-12">
                      <h5 class="text-left p-1 title is-6">App/Website Name</h5>
                      <div class="p-input">
                          <InputText v-model="store.config.env.app_name"
                                     placeholder="VaahCMS"
                                     name="config-app_name"
                                     class="p-inputtext-sm" id="app-name"
                                     data-testid="configuration-app_name"
                                     required
                                     @update:modelValue="store.onUpdateAppName"
                                     @keydown.space.prevent
                          />
                          <div class="required-field hidden"></div>
                      </div>
                  </div>
              </div>

              <div class="grid p-fluid">
                  <div class="col-12 md:col-4">
                      <h5 class="text-left p-1 title is-6">Database Type</h5>
                      <div class="p-inputgroup">
                          <Dropdown v-model="store.config.env.db_connection"
                                    :options="store.assets.database_types"
                                    name="config-db_connection"
                                    optionLabel="name" optionValue="slug"
                                    placeholder="Database Type" class="is-small"
                                    :inputProps="store.config.data_testid_db_type"
                                    required
                          />
                          <div class="required-field hidden"></div>
                      </div>
                  </div>

                  <div class="col-12 md:col-4">
                      <h5 class="text-left p-1 title is-6">Database Host</h5>
                      <div class="p-inputgroup">
                          <InputText v-model="store.config.env.db_host"
                                     name="config-db_host"
                                     placeholder="Database Host"
                                     class="p-inputtext-sm"
                                     data-testid="configuration-db_host"
                                     required
                          />
                          <div class="required-field hidden"></div>
                      </div>
                  </div>

                  <div class="col-12 md:col-4">
                      <h5 class="text-left p-1 title is-6">Database Port</h5>
                      <div class="p-inputgroup">
                          <InputText v-model="store.config.env.db_port"
                                     name="config-db_port"
                                     placeholder="Database Port"
                                     class="p-inputtext-sm"
                                     data-testid="configuration-db_port"
                                     required
                          />
                          <div class="required-field hidden"></div>
                      </div>
                  </div>
              </div>

              <div class="grid p-fluid">
                  <div class="col-12 md:col-4">
                      <h5 class="text-left p-1 title is-6">Database Name</h5>
                      <div class="p-inputgroup">
                          <InputText v-model="store.config.env.db_database"
                                     placeholder="Database Name"
                                     name="config-db_database"
                                     class="p-inputtext-sm"
                                     data-testid="configuration-db_name"
                                     required
                          />
                          <div class="required-field hidden"></div>
                      </div>
                  </div>

                  <div class="col-12 md:col-4">
                      <h5 class="text-left p-1 title is-6">Database Username</h5>
                      <div class="p-inputgroup">
                          <InputText v-model="store.config.env.db_username"
                                     placeholder="Database Username"
                                     name="config-db_username"
                                     class="p-inputtext-sm"
                                     data-testid="configuration-db_username"
                                     required
                          />
                          <div class="required-field hidden"></div>
                      </div>
                  </div>

                  <div class="col-12 md:col-4">
                      <h5 class="text-left p-1 title is-6">Database Password</h5>
                      <div class="p-inputgroup">
                          <Password v-model="store.config.env.db_password" :feedback="false"
                                    toggleMask
                                    :inputProps="store.config.data_testid_db_password"
                                    name="config-db_password"
                                    input-class="w-full p-inputtext-sm"
                                    placeholder="Database Password"
                                    :pt="{
                                        showicon: {
                                            'data-testid': `configuration-db_password_eye`
                                        }
                                    }"
                          />
                      </div>
                  </div>
              </div>

              <Button v-if="store.config.env.db_is_valid"
                      @click="store.testDatabaseConnection()"
                      label="Test Database connection"
                      :loading="store.is_btn_loading_db_connection"
                      icon="pi pi-check"
                      class="p-button-sm mt-2 mb-3" severity="success"
                      data-testid="configuration-test_db_connection"
                      :pt="{
                                    label: {
                                            'data-testid': `configuration-test_db_connection_btn_text`
                                      }
                                  }"/>

              <Button v-else
                      @click="store.testDatabaseConnection()"
                      label="Test Database connection"
                      :loading="store.is_btn_loading_db_connection"
                      icon="pi pi-database" class="p-button-sm mt-2 mb-3" outlined
                      data-testid="configuration-test_db_connection"
                      :pt="{
                                    label: {
                                            'data-testid': `configuration-test_db_connection_btn_text`
                                      }
                                  }"/>



              <div class="grid p-fluid">
                  <div class="col-12 md:col-4">
                      <h5 class="text-left p-1 title is-6">Mail Provider</h5>
                      <div class="p-inputgroup">
                          <Dropdown v-model="store.config.env.mail_provider"
                                    :options="store.assets.mail_sample_settings"
                                    @change="store.setMailConfigurations()"
                                    optionLabel="name" optionValue="slug"
                                    placeholder="Select Mail Provider"
                                    class="is-small"
                                    :inputProps="store.config.data_testid_mail_provider"/>
                      </div>
                  </div>

                  <div class="col-12 md:col-4">
                      <h5 class="text-left p-1 title is-6">Mail Driver</h5>
                      <div class="p-inputgroup">
                          <InputText v-model="store.config.env.mail_driver"
                                     placeholder="Mail Driver" class="p-inputtext-sm"
                                     data-testid="configuration-mail_driver"/>
                      </div>
                  </div>

                  <div class="col-12 md:col-4">
                      <h5 class="text-left p-1 title is-6">Mail Host</h5>
                      <div class="p-inputgroup">
                          <InputText v-model="store.config.env.mail_host"
                                     placeholder="Mail Host" class="p-inputtext-sm"
                                     data-testid="configuration-mail_host"/>
                      </div>
                  </div>
              </div>

              <div class="grid p-fluid">
                  <div class="col-12 md:col-4">
                      <h5 class="text-left p-1 title is-6">Mail Port</h5>
                      <div class="p-inputgroup">
                          <InputText v-model="store.config.env.mail_port"
                                     placeholder="Mail Port" class="p-inputtext-sm"
                                     data-testid="configuration-mail_port"/>
                      </div>
                  </div>

                  <div class="col-12 md:col-4">
                      <h5 class="text-left p-1 title is-6">Mail Username</h5>
                      <div class="p-inputgroup">
                          <InputText v-model="store.config.env.mail_username"
                                     placeholder="Mail Username" class="p-inputtext-sm"
                                     data-testid="configuration-mail_username"/>
                      </div>
                  </div>

                  <div class="col-12 md:col-4">
                      <h5 class="text-left p-1 title is-6">Mail Password</h5>
                      <div class="p-inputgroup">
                          <Password v-model="store.config.env.mail_password"
                                    :feedback="false" toggleMask
                                    input-class="w-full p-inputtext-sm" placeholder="Mail Password"
                                    :inputProps="store.config.data_testid_mail_password"
                                    :pt="{
                                        showicon: {
                                            'data-testid': `configuration-mail_password_eye`
                                        }
                                    }"
                          />
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
                                    placeholder="Select Mail Encryption" class="is-small"
                                    :inputProps="store.config.data_testid_mail_encryption"/>
                      </div>
                  </div>

                  <div class="col-12 md:col-4">
                      <h5 class="text-left p-1 title is-6">From Name</h5>
                      <div class="p-inputgroup">
                          <InputText v-model="store.config.env.mail_from_name"
                                     placeholder="From Name" class="p-inputtext-sm"
                                     data-testid="configuration-mail_from_name"
                                     required
                          />
                          <div class="required-field hidden"></div>
                      </div>
                  </div>

                  <div class="col-12 md:col-4">
                      <h5 class="text-left p-1 title is-6">From Email</h5>
                      <div class="p-inputgroup">
                          <InputText v-model="store.config.env.mail_from_address"
                                     type="email"
                                     placeholder="From Email" class="p-inputtext-sm"
                                     data-testid="configuration-mail_from_address"
                                     required
                          />
                          <div class="required-field hidden"></div>
                      </div>
                  </div>
              </div>
            <div class="">
              <Button v-if="store.config.env.mail_is_valid"
                      @click="$event => $refs.op.toggle($event)"
                      label="Test Mail Configuration"
                      icon="pi pi-check"
                      class="p-button-sm mt-2 mb-3" severity="success"
                      data-testid="configuration-test_mail"
                      :pt="{
                                    label: {
                                            'data-testid': `configuration-test_mail_btn_text`
                                      }
                                  }"/>

              <Button v-else
                      @click="$event => $refs.op.toggle($event)"
                      label="Test Mail Configuration"
                      icon="pi pi-envelope"
                      class="p-button-sm mt-2 mb-3" outlined
                      data-testid="configuration-test_mail"
                      :pt="{
                                    label: {
                                            'data-testid': `configuration-test_mail_btn_text`
                                      }
                                  }"/>

              <OverlayPanel ref="op" appendTo="body"
                            :showCloseIcon="true" id="overlay_panel"
                            style="width: 400px" :breakpoints="{'960px': '75vw'}"
                            :pt="{
                                root: {
                                   class: 'shadow-1 mt-2'
                                },
                                    closebutton: {
                                            'data-testid': `configuration-test_mail_close`,
                                            style: {
                                                width: '1.5rem',
                                                height: '1.5rem',
                                                top: '-0.5rem',
                                                right: '-0.5rem'
                                            }
                                    },
                                    closeicon: {
                                        class: 'w-5'
                                    },
                                    content: {
                                        class: 'p-2'
                                    }
                                  }">
                  <div class="col-12">
                      <h5 class="text-left p-1 pt-0 title is-6">Mail Username</h5>
                      <div class="p-inputgroup flex-1">
                          <InputText type="email" v-model="store.config.env.test_email_to"
                                     placeholder="Your email" class=""
                                     data-testid="configuration-test_email_to"/>
                          <Button :loading="store.is_btn_loading_mail_config"
                                  @click="store.testMailConfiguration"
                                  label="Send Email"
                                  class="p-button-sm is-small"
                                  data-testid="configuration-send_mail"
                                  :pt="{
                                    label: {
                                            'data-testid': `configuration-send_mail_btn_text`
                                      }
                                  }"/>
                      </div>
                  </div>
              </OverlayPanel>
            </div>

              <div class="grid p-fluid">
                  <div class="col-12">
                      <div class="flex justify-content-end gap-2">
                          <p class="text-xs">Test Database connection for next step</p>
                          <Button label="Save & Next" :loading="store.is_btn_loading_config"
                                  :disabled="!store.config.env.db_is_valid"
                                  class="p-button-sm w-auto" @click="store.validateConfigurations"
                                  data-testid="configuration-save_btn"
                                  :pt="{
                                    label: {
                                            'data-testid': `configuration-save_btn_text`
                                      }
                                  }"></Button>
                      </div>
                  </div>
              </div>
          </div>
      </div>


  </div>
</template>

