<script setup>
import {onMounted, ref, watch} from "vue";
import { useRegistrationStore } from '../../stores/store-registrations'

import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import {useRoute} from 'vue-router';
import { vaah } from "../../vaahvue/pinia/vaah"


const store = useRegistrationStore();
const route = useRoute();
const useVaah = vaah();

onMounted(async () => {
    if(route.params && route.params.id)
    {
        await store.getItem(route.params.id);
    }
    store.getFormMenu();

});


//--------form_menu
const form_menu = ref();
const toggleFormMenu = (event) => {
    form_menu.value.toggle(event);

};
//--------/form_menu

</script>
<template>
    <div class="col-5" >
        <Panel class="is-small">
            <Message severity="error"
                         class="p-container-message"
                         :closable="false"
                         icon="pi pi-trash"
                         v-if="store.item && store.item.deleted_at"
            >
                <div class="flex align-items-center justify-content-between">
                    <div>
                        Deleted {{store.item.deleted_at}}
                    </div>

                    <div>
                        <Button label="Restore"
                                class="p-button-sm"
                                @click="store.itemAction('restore')"
                                data-testid="register-form_item_action_restore"
                        >
                        </Button>
                    </div>
                </div>
            </Message>

            <template class="p-1" #header>
                <div class="flex flex-row">
                    <div class="p-panel-title">
                        <span v-if="store.item && store.item.id">
                            {{ store.item.name }}
                        </span>
                        <span v-else>
                            Create
                        </span>
                    </div>
                </div>
            </template>

            <template #icons>
                <div class="p-inputgroup">
                    <Button v-if="store.item && store.item.id"
                            class="p-button-sm"
                            :label=" '#' + store.item.id "
                            @click="useVaah.copy(store.item.id)"
                            data-testid="registration-form_id"
                    />

                    <Button label="Save"
                            v-if="store.item && store.item.id && store.hasPermission('can-update-registrations')"
                            @click="store.itemAction('save')"
                            icon="pi pi-save"
                            data-testid="register-form_item_action_save"
                            class="p-button-sm"
                    />

                    <Button v-else-if="store.hasPermission('can-create-registrations')"
                            label="Create & New"
                            @click="store.itemAction('create-and-new')"
                            icon="pi pi-save"
                            data-testid="register-form_item_action_create_and_new"
                            class="p-button-sm"
                    />

                    <!--form_menu-->
                    <Button icon="pi pi-angle-down"
                            @click="toggleFormMenu"
                            aria-haspopup="true"
                            data-testid="register-form_toggle_form_menu_list"
                            class="p-button-sm"
                            v-if="store.hasPermission('can-update-registrations') || store.hasPermission('can-manage-registrations')"
                    />

                    <Menu ref="form_menu"
                          :model="store.form_menu_list"
                          :popup="true"
                    />
                    <!--/form_menu-->

                    <Button v-if="(store.item && store.item.id) || store.hasPermission('can-read-registrations')"
                            class="p-button-sm"
                            icon="pi pi-eye"
                            v-tooltip.top="'View'"
                            @click="store.toView(store.item)"
                    />

                    <Button class="p-button-sm"
                            icon="pi pi-times"
                            @click="store.toList()"
                            data-testid="register-form_to_list"
                    />
                </div>
            </template>


            <div v-if="store.item && store.assets" class="mt-2">
                <VhField label="Email">
                    <InputText class="w-full"
                               v-model="store.item.email"
                               name="register-email"
                               data-testid="register-email"
                               @input="store.validateEmail(store.item.email)"
                    />

                    <span v-if="store.email_validation_message === false"
                          class="text-xs text-red-500"
                    >
                        Please include a '@domain' in the email address. {{ store.item.email }} is lacking a "@domain" in the address.
                    </span>
                </VhField>

                <VhField label="Username">
                    <InputText class="w-full"
                               v-model="store.item.username"
                               name="register-username"
                               data-testid="register-username"
                    />
                </VhField>

                <VhField v-if="store.item && store.item.id" label="New Password">
                    <Password  class="w-full"
                               v-model="store.item.password"
                               :feedback="false"
                               toggleMask
                               name="register-password"
                               data-testid="register-password"
                               inputClass="w-full"
                    />
                </VhField>

                <VhField v-else label="Password">
                    <Password  class="w-full"
                               v-model="store.item.password"
                               :feedback="false"
                               toggleMask
                               name="register-password"
                               data-testid="register-password"
                               inputClass="w-full"
                    />
                </VhField>


                <VhField label="Display Name" v-if="!store.isHidden('display_name')">
                    <InputText class="w-full"
                               v-model="store.item.display_name"
                               name="register-display_name"
                               data-testid="register-display_name"
                    />
                </VhField>

                <VhField label="Title" v-if="!store.isHidden('title')">
                    <Dropdown v-model="store.item.title"
                              :options="store.assets.name_titles"
                              optionLabel="name"
                              optionValue="slug"
                              placeholder="Select a title"
                              data-testid="register-title"
                              class="w-full"
                    />
                </VhField>

                <VhField label="Designation" v-if="!store.isHidden('designation')">
                    <InputText class="w-full"
                               v-model="store.item.designation"
                               name="register-designation"
                               data-testid="register-designation"
                    />
                </VhField>

                <VhField label="First Name">
                    <InputText class="w-full"
                               v-model="store.item.first_name"
                               name="register-first_name"
                               data-testid="register-first_name"
                    />
                </VhField>

                <VhField label="Middle Name" v-if="!store.isHidden('middle_name')">
                    <InputText class="w-full"
                               v-model="store.item.middle_name"
                               name="register-middle_name"
                               data-testid="register-middle_name"
                    />
                </VhField>

                <VhField label="Last Name" v-if="!store.isHidden('last_name')">
                    <InputText class="w-full"
                               v-model="store.item.last_name"
                               name="register-last_name"
                               data-testid="register-last_name"
                    />
                </VhField>

                <VhField label="Gender" v-if="!store.isHidden('gender')">
                    <SelectButton v-model="store.item.gender"
                                  :options="store.gender_options"
                                  aria-labelledby="single"
                                  optionLabel="name"
                                  optionValue="value"
                                  data-testid="register-gender"
                    >
                        <template #option="slotProps">
                            <i :class="slotProps.option.icon"></i>
                            {{slotProps.option.name}}
                        </template>
                    </SelectButton>
                </VhField>

                <VhField label="Country Code" v-if="!store.isHidden('country_calling_code')">
                    <Dropdown v-model="store.item.country_calling_code"
                              :options="store.assets.country_calling_code"
                              optionLabel='calling_code'
                              optionValue='calling_code'
                              placeholder="Enter your country code"
                              data-testid="register-country_calling_code"
                              class="w-full"
                    >
                    </Dropdown>
                </VhField>

                <VhField label="Phone" v-if="!store.isHidden('phone')">
                    <InputNumber inputId="withoutgrouping"
                                 v-model="store.item.phone"
                                 :useGrouping="false"
                                 name="register-phone"
                                 data-testid="register-phone"
                                 class="w-full"
                    />
                </VhField>

                <VhField label="Bio" v-if="!store.isHidden('bio')">
                    <Editor v-model="store.item.bio"
                            editorStyle="height: 320px"
                            name="register-bio"
                            data-testid="register-bio"
                    />
                </VhField>

                <VhField label="Timezone" v-if="!store.isHidden('timezone')">
                    <Dropdown v-model="store.item.timezone"
                              :options="store.assets.timezones"
                              optionLabel="name"
                              optionValue="slug"
                              :filter="true"
                              placeholder="Enter Your Timezone"
                              :showClear="true"
                              data-testid="register-timezone"
                              class="w-full"
                    />
                </VhField>

                <VhField label="Alternate Email" v-if="!store.isHidden('alternate_email')">
                    <InputText class="w-full"
                               v-model="store.item.alternate_email"
                               name="register-alternate_email"
                               data-testid="register-alternate_email"
                    />
                </VhField>

                <VhField label="Date of Birth" v-if="!store.isHidden('birth')">
                    <Calendar inputId="dateformat"
                              v-model="store.item.birth"
                              :showIcon="true"
                              dateFormat="mm-dd-yy"
                              data-testid="register-birth"
                              class="w-full"
                    />
                </VhField>

                <VhField label="Country" v-if="!store.isHidden('country')">
                    <AutoComplete class="w-full"
                                  v-model="store.item.country"
                                  :suggestions="store.filtered_country_codes"
                                  @complete="store.searchCountryCode"
                                  @item-select="store.onSelectCountryCode"
                                  placeholder="Enter Your Country"
                                  optionLabel="name"
                                  name="account-country"
                                  data-testid="register-country"
                                  inputClass="w-full"
                    />
                </VhField>

                <VhField label="Status">
                    <Dropdown class="w-full"
                              v-model="store.item.status"
                              :options="store.assets.registration_statuses"
                              optionLabel="name"
                              optionValue="slug"
                              placeholder="Select a status"
                              data-testid="register-status"
                    />
                </VhField>

                <template v-if="store.assets && store.assets.custom_fields
                && store.item.meta && store.item.meta['custom_fields']"
                          v-for="(custom_field,key) in store.assets.custom_fields.value"
                          :key="key"
                >
                    <VhField :label="useVaah.toLabel(custom_field.name)"
                             v-if="!custom_field.to_registration"
                    >
                       <Textarea v-if="custom_field.type === 'textarea'"
                                 class="w-full"
                                 rows="5"
                                 cols="30"
                                 :name=" 'account-meta_'+custom_field.slug"
                                 :data-testid="'account-meta_'+custom_field.slug"
                                 :min="custom_field.min"
                                 :max="custom_field.max"
                                 :minlength="custom_field.minlength"
                                 :maxlength="custom_field.maxlength"
                                 v-model="store.item.meta['custom_fields'][custom_field.slug]"
                       />

                        <Password v-else-if="custom_field.type === 'password'"
                                  class="w-full"
                                  :name=" 'account-meta_'+custom_field.slug"
                                  :data-testid="'account-meta_'+custom_field.slug"
                                  :min="custom_field.min"
                                  :max="custom_field.max"
                                  :minlength="custom_field.minlength"
                                  :maxlength="custom_field.maxlength"
                                  v-model="store.item.meta['custom_fields'][custom_field.slug]"
                                  toggleMask
                                  inputClass="w-full"
                        />

                        <InputText v-else
                                   class="w-full"
                                   :name=" 'account-meta_'+custom_field.slug"
                                   :data-testid="'account-meta_'+custom_field.slug"
                                   :type="custom_field.type"
                                   :min="custom_field.min"
                                   :max="custom_field.max"
                                   :minlength="custom_field.minlength"
                                   :maxlength="custom_field.maxlength"
                                   v-model="store.item.meta['custom_fields'][custom_field.slug]"
                        />
                    </VhField>
                </template>
            </div>
        </Panel>
    </div>
</template>
