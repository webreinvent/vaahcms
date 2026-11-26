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
              <!-- M6-T5 — `is-6` is a PrimeFlex heading size: 0.75rem =
                   10.5px at the 14px root, below the 12px floor of the
                   DESIGN-SYSTEM.md §6 scale. The field label is body
                   copy at 14px. -->
              <div class="text-left p-1 title vc-text-14" id="cfg-app-url">App URL</div>

              <Fluid class="grid">
                  <div class="col-12">
                      <div class="p-input">
                          <InputText aria-labelledby="cfg-app-url" size="small" v-model="store.config.env.app_url" disabled placeholder="App URL" class="" id="app-url" data-testid="configuration-app_url" required />
                          <div class="required-field hidden"></div>
                      </div>
                  </div>
              </Fluid>

              <Fluid class="grid">
                  <div class="col-12 md:col-4">
                      <div class="text-left p-1 title vc-text-14" id="cfg-env">ENV</div>
                      <InputGroup>

                          <Select aria-labelledby="cfg-env" v-model="store.config.env.app_env" :options="store.assets.environments"
                                    @change="store.loadConfigurations()"
                                    optionLabel="name" optionValue="slug"
                                    placeholder="Select Env" class="vc-dense"
                                    :inputProps="store.config.data_testid_app_env"
                                    required
                          />
                          <div class="required-field hidden"></div>
                      </InputGroup>

                      <InputText aria-labelledby="cfg-env" v-if="store.config.env.app_env == 'custom'"
                                 v-model="store.config.env.app_env_custom"
                                 placeholder="Env File Name" class="vc-dense"
                                 id="app-env-custom"
                                 data-testid="configuration-custom_evn"
                                 required
                      />
                      <div class="required-field hidden"></div>
                  </div>
                  <div class="col-12 md:col-4">
                      <div class="text-left p-1 title vc-text-14" id="cfg-debug">Debug</div>
                      <InputGroup>
                          <Select aria-labelledby="cfg-debug" v-model="store.config.env.app_debug"
                                    name="config-db_connection"
                                    :options="store.debug_option" optionLabel="name"
                                    optionValue="slug" placeholder="Select Debug"
                                    class="vc-dense"
                                    :inputProps="store.config.data_testid_debug"
                                    required
                          />
                          <div class="required-field hidden"></div>
                      </InputGroup>
                  </div>
                  <div class="col-12 md:col-4">
                      <div class="text-left p-1 title vc-text-14" id="cfg-timezone">Timezone</div>
                      <InputGroup>
                          <Select aria-labelledby="cfg-timezone" v-model="store.config.env.app_timezone"
                                    :options="store.assets.timezones"
                                    optionLabel="name" optionValue="slug" :filter="true"
                                    placeholder="Select Timezone" class="vc-dense"
                                    :inputProps="store.config.data_testid_timezone"
                                    required
                          />
                          <div class="required-field hidden"></div>
                      </InputGroup>
                  </div>
              </Fluid>
              <Fluid class="grid">
                  <div class="col-12">
                      <div class="text-left p-1 title vc-text-14" id="cfg-app-name">App/Website Name</div>
                      <div class="p-input">
                          <InputText aria-labelledby="cfg-app-name" size="small" v-model="store.config.env.app_name" placeholder="Enter your website or app name" name="config-app_name" class="" id="app-name" data-testid="configuration-app_name" required @update:modelValue="store.onUpdateAppName" @keydown.space.prevent />
                          <div class="required-field hidden"></div>
                      </div>
                  </div>
              </Fluid>

              <Fluid class="grid">
                  <div class="col-12 md:col-4">
                      <div class="text-left p-1 title vc-text-14" id="cfg-db-type">Database Type</div>
                      <InputGroup>
                          <Select aria-labelledby="cfg-db-type" v-model="store.config.env.db_connection"
                                    :options="store.assets.database_types"
                                    name="config-db_connection"
                                    optionLabel="name" optionValue="slug"
                                    placeholder="Database Type" class="vc-dense"
                                    :inputProps="store.config.data_testid_db_type"
                                    required
                          />
                          <div class="required-field hidden"></div>
                      </InputGroup>
                  </div>

                  <div class="col-12 md:col-4">
                      <div class="text-left p-1 title vc-text-14" id="cfg-db-host">Database Host</div>
                      <InputGroup>
                          <InputText aria-labelledby="cfg-db-host" size="small" v-model="store.config.env.db_host" name="config-db_host" placeholder="Database Host" class="" data-testid="configuration-db_host" required />
                          <div class="required-field hidden"></div>
                      </InputGroup>
                  </div>

                  <div class="col-12 md:col-4">
                      <div class="text-left p-1 title vc-text-14" id="cfg-db-port">Database Port</div>
                      <InputGroup>
                          <InputText aria-labelledby="cfg-db-port" size="small" v-model="store.config.env.db_port" name="config-db_port" placeholder="Database Port" class="" data-testid="configuration-db_port" required />
                          <div class="required-field hidden"></div>
                      </InputGroup>
                  </div>
              </Fluid>

              <Fluid class="grid">
                  <div class="col-12 md:col-4">
                      <div class="text-left p-1 title vc-text-14" id="cfg-db-name">Database Name</div>
                      <InputGroup>
                          <InputText aria-labelledby="cfg-db-name" size="small" v-model="store.config.env.db_database" placeholder="Database Name" name="config-db_database" class="" data-testid="configuration-db_name" required />
                          <div class="required-field hidden"></div>
                      </InputGroup>
                  </div>

                  <div class="col-12 md:col-4">
                      <div class="text-left p-1 title vc-text-14" id="cfg-db-username">Database Username</div>
                      <InputGroup>
                          <InputText aria-labelledby="cfg-db-username" size="small" v-model="store.config.env.db_username" placeholder="Database Username" name="config-db_username" class="" data-testid="configuration-db_username" required />
                          <div class="required-field hidden"></div>
                      </InputGroup>
                  </div>

                  <div class="col-12 md:col-4">
                      <div class="text-left p-1 title vc-text-14" id="cfg-db-password">Database Password</div>
                      <InputGroup>
                          <Password aria-labelledby="cfg-db-password" size="small" v-model="store.config.env.db_password" :feedback="false" toggleMask :inputProps="store.config.data_testid_db_password" name="config-db_password" input-class="w-full" placeholder="Database Password" :pt="{ showicon: { 'data-testid': `configuration-db_password_eye` } }" />
                      </InputGroup>
                  </div>
              </Fluid>

              <Button size="small" v-if="store.config.env.db_is_valid" @click="store.testDatabaseConnection()" label="Test Database connection" :loading="store.is_btn_loading_db_connection" icon="pi pi-check" class=" mt-2 mb-3" severity="success" data-testid="configuration-test_db_connection_valid" :pt="{ label: { 'data-testid': `configuration-test_db_connection_btn_text` } }"/>

              <Button size="small" v-else @click="store.testDatabaseConnection()" label="Test Database connection" :loading="store.is_btn_loading_db_connection" icon="pi pi-database" class=" mt-2 mb-3" outlined severity="info" data-testid="configuration-test_db_connection" :pt="{ label: { 'data-testid': `configuration-test_db_connection_btn_text` } }"/>



              <Fluid class="grid">
                  <div class="col-12 md:col-4">
                      <div class="text-left p-1 title vc-text-14" id="cfg-mail-provider">Mail Provider</div>
                      <InputGroup>
                          <Select aria-labelledby="cfg-mail-provider" v-model="store.config.env.mail_provider"
                                    :options="store.assets.mail_sample_settings"
                                    @change="store.setMailConfigurations()"
                                    optionLabel="name" optionValue="slug"
                                    placeholder="Select Mail Provider"
                                    class="vc-dense"
                                    :inputProps="store.config.data_testid_mail_provider"/>
                      </InputGroup>
                  </div>

                  <div class="col-12 md:col-4">
                      <div class="text-left p-1 title vc-text-14" id="cfg-mail-driver">Mail Driver</div>
                      <InputGroup>
                          <InputText aria-labelledby="cfg-mail-driver" size="small" v-model="store.config.env.mail_driver" placeholder="Mail Driver" class="" data-testid="configuration-mail_driver"/>
                      </InputGroup>
                  </div>

                  <div class="col-12 md:col-4">
                      <div class="text-left p-1 title vc-text-14" id="cfg-mail-host">Mail Host</div>
                      <InputGroup>
                          <InputText aria-labelledby="cfg-mail-host" size="small" v-model="store.config.env.mail_host" placeholder="Mail Host" class="" data-testid="configuration-mail_host"/>
                      </InputGroup>
                  </div>
              </Fluid>

              <Fluid class="grid">
                  <div class="col-12 md:col-4">
                      <div class="text-left p-1 title vc-text-14" id="cfg-mail-port">Mail Port</div>
                      <InputGroup>
                          <InputText aria-labelledby="cfg-mail-port" size="small" v-model="store.config.env.mail_port" placeholder="Mail Port" class="" data-testid="configuration-mail_port"/>
                      </InputGroup>
                  </div>

                  <div class="col-12 md:col-4">
                      <div class="text-left p-1 title vc-text-14" id="cfg-mail-username">Mail Username</div>
                      <InputGroup>
                          <InputText aria-labelledby="cfg-mail-username" size="small" v-model="store.config.env.mail_username" placeholder="Mail Username" class="" data-testid="configuration-mail_username"/>
                      </InputGroup>
                  </div>

                  <div class="col-12 md:col-4">
                      <div class="text-left p-1 title vc-text-14" id="cfg-mail-password">Mail Password</div>
                      <InputGroup>
                          <Password aria-labelledby="cfg-mail-password" size="small" v-model="store.config.env.mail_password" :feedback="false" toggleMask input-class="w-full" placeholder="Mail Password" :inputProps="store.config.data_testid_mail_password" :pt="{ showicon: { 'data-testid': `configuration-mail_password_eye` } }" />
                      </InputGroup>
                  </div>
              </Fluid>

              <Fluid class="grid">
                  <div class="col-12 md:col-4">
                      <div class="text-left p-1 title vc-text-14" id="cfg-mail-encryption">Mail Encryption</div>
                      <InputGroup>
                          <Select aria-labelledby="cfg-mail-encryption" v-model="store.config.env.mail_encryption"
                                    :options="store.assets.mail_encryption_types"
                                    optionLabel="name" optionValue="slug"
                                    placeholder="Select Mail Encryption" class="vc-dense"
                                    :inputProps="store.config.data_testid_mail_encryption"/>
                      </InputGroup>
                  </div>

                  <div class="col-12 md:col-4">
                      <div class="text-left p-1 title vc-text-14" id="cfg-from-name">From Name</div>
                      <InputGroup>
                          <InputText aria-labelledby="cfg-from-name" size="small" v-model="store.config.env.mail_from_name" placeholder="From Name" class="" data-testid="configuration-mail_from_name" required />
                          <div class="required-field hidden"></div>
                      </InputGroup>
                  </div>

                  <div class="col-12 md:col-4">
                      <div class="text-left p-1 title vc-text-14" id="cfg-from-email">From Email</div>
                      <InputGroup>
                          <InputText aria-labelledby="cfg-from-email" size="small" v-model="store.config.env.mail_from_address" type="email" placeholder="From Email" class="" data-testid="configuration-mail_from_address" required />
                          <div class="required-field hidden"></div>
                      </InputGroup>
                  </div>
              </Fluid>
            <div class="">
              <Button v-if="store.config.env.mail_is_valid"
                      @click="$event => $refs.op.toggle($event)"
                      label="Test Mail Configuration"
                      icon="pi pi-check"
                      size="small"
                      class="mt-2 mb-3" severity="success"
                      data-testid="configuration-test_mail_valid"
                      :pt="{
                                    label: {
                                            'data-testid': `configuration-test_mail_btn_text`
                                      }
                                  }"/>

              <Button v-else
                      @click="$event => $refs.op.toggle($event)"
                      label="Test Mail Configuration"
                      icon="pi pi-envelope"
                      size="small"
                      class="mt-2 mb-3"
                      outlined
                      severity="info"
                      data-testid="configuration-test_mail"
                      :pt="{
                                    label: {
                                            'data-testid': `configuration-test_mail_btn_text`
                                      }
                                  }"/>

              <Popover ref="op" appendTo="body"
                            id="overlay_panel"
                            style="width: 400px" :breakpoints="{'960px': '75vw'}"
                            :pt="{
                                root: {
                                   class: 'shadow-1 mt-2'
                                },
                                    content: {
                                        class: 'p-2'
                                    }
                                  }">
                  <div class="col-12 relative">
                      <!--OpenVue v4 Popover renders no closebutton/closeicon
                          parts — the close affordance is explicit markup
                          (the v3 closebutton/closeicon PT sections were
                          dead: nothing in the v4 template consumes them).-->
                      <Button icon="pi pi-times" aria-label="Close" variant="text" size="small"
                              class="absolute right-0 top-0"
                              @click="$refs.op.hide()"
                              data-testid="configuration-test_mail_close"/>
                      <div class="text-left p-1 pt-0 title is-6" id="cfg-test-mail-to">Mail Username</div>
                      <InputGroup class="flex-1">
                          <InputText aria-labelledby="cfg-test-mail-to" type="email" v-model="store.config.env.test_email_to"
                                     placeholder="Your email" class=""
                                     data-testid="configuration-test_email_to"/>
                          <Button size="small" :loading="store.is_btn_loading_mail_config" @click="store.testMailConfiguration" label="Send Email" class=" vc-dense" data-testid="configuration-send_mail" :pt="{ label: { 'data-testid': `configuration-send_mail_btn_text` } }"/>
                      </InputGroup>
                  </div>
              </Popover>
            </div>

              <Fluid class="grid">
                  <div class="col-12">
                      <!-- UT-55 — the helper text and the button shared one
                           line; on a 375px viewport the button was squeezed
                           to ~50px and its label broke over three lines. The
                           row now wraps, and the label stays on one line. -->
                      <div class="flex flex-wrap justify-content-end items-center gap-2">
                          <p class="vc-text-13">Test Database connection for next step</p>
                          <Button size="small" label="Save & Next" :loading="store.is_btn_loading_config" :disabled="!store.config.env.db_is_valid" class="vaah-btn-primary w-auto" @click="store.validateConfigurations" data-testid="configuration-save_btn" :pt="{ label: { 'data-testid': `configuration-save_btn_text` } }"></Button>
                      </div>
                  </div>
              </Fluid>
          </div>
      </div>


  </div>
</template>

