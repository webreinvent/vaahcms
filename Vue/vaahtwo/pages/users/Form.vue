<script setup>
import {onMounted, ref, watch, watchEffect} from "vue";
import { useUserStore } from '../../stores/store-users'
import { useRootStore } from '../../stores/root'
import { vaah } from "../../vaahvue/pinia/vaah"
import FileUploader from "./components/FileUploader.vue";


import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import {useRoute} from 'vue-router';


const store = useUserStore();
const root = useRootStore();
const route = useRoute();
const useVaah = vaah();

onMounted(async () => {
    if (route.params && route.params.id) {
        await store.getItem(route.params.id);
    }

    store.getFormMenu();

    root.getIsActiveStatusOptions();
});


// if (store && store.item && store.item.email) {
//     watchEffect(store.item.email, (currentValue, oldValue) => {
//         alert(currentValue);
//         store.item.email = currentValue;
//         store.validateEmail(currentValue);
//     });
// }

const myUploader = ref();

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
                            data-testid="user-form_id"
                            @click="useVaah.copy(store.item.id)"
                    />

                    <Button label="Save"
                            class="p-button-sm"
                            v-if="store.item && store.item.id && store.hasPermission('can-update-users')"
                            @click="store.itemAction('save')"
                            data-testid="user-edit_save"
                            icon="pi pi-save"
                    />

                    <Button label="Create & New"
                            class="p-button-sm"
                            v-else
                            @click="store.itemAction('create-and-new')"
                            data-testid="user-new_save"
                            icon="pi pi-save"
                            v-if="store.hasPermission('can-create-users')"
                    />


                    <!--form_menu-->
                    <Button class="p-button-sm"
                            @click="toggleFormMenu"
                            icon="pi pi-angle-down"
                            aria-haspopup="true"
                            data-testid="user-form_menu"
                            v-if="store.hasPermission('can-update-users') || store.hasPermission('can-manage-users')"
                    />

                    <Menu ref="form_menu"
                          :model="store.form_menu_list"
                          :popup="true"
                    />
                    <!--/form_menu-->

                    <Button v-if="store.item && store.item.id"
                            class="p-button-sm"
                            icon="pi pi-eye"
                            v-tooltip.top="'View'"
                            data-testid="user-form_view"
                            @click="store.toView(store.item)"
                    />

                    <Button class="p-button-sm"
                            icon="pi pi-times"
                            data-testid="user-list_view"
                            @click="store.toList()"
                    />
                </div>



            </template>


            <div v-if="store.item && store.assets" class="pt-2">
                <div class="field mb-4 flex justify-content-between align-items-center"
                     v-if="root && root.assets && store.item.id">

                    <img v-if="store.item.avatar"
                         :src="store.item.avatar"
                         alt=""
                         width="64"
                         height="64"
                         style="border-radius: 50%"
                    >

                    <div v-if="store.item.avatar_url">
                        <Button class="p-button-sm w-max"
                                data-testid="profile-save"
                                @click="store.removeAvatar"
                                label="Remove"></Button>
                    </div>

                    <div class="w-max">
                        <FileUploader placeholder="Upload Avatar"
                                      :is_basic="true"
                                      data-testid="user-form_upload_avatar"
                                      :auto_upload="true"
                                      :uploadUrl="root.assets.urls.upload"
                                      :pt="{
                                          chooseButton: 'p-button-sm',
                                          label: 'line-height-2',
                                          uploadIcon: {
                                              style: {
                                                  width: '0.7rem',
                                                  height: '0.7rem'
                                              }
                                          }
                                      }"
                        />
                    </div>

                </div>

                <VhField label="Email" class="mb-2">
                    <InputText :class="'w-full p-inputtext-sm '+ store.email_error.class"
                               v-model="store.item.email"
                               @input="store.validateEmail"
                               name="account-email"
                               data-testid="account-email"
                               type="email"
                               aria-describedby="email-error"
                               placeholder="Email"
                    />
                    <small id="email-error" class="p-error">{{ store.email_error.msg }}</small>
                </VhField>

                <VhField label="Username" class="mb-2">
                    <InputText class="w-full p-inputtext-sm"
                               v-model="store.item.username"
                               name="account-username"
                               data-testid="account-username"
                               placeholder="Username"
                    />
                </VhField>

                <VhField label="Password" class="mb-2">
                    <Password class="w-full"
                              v-model="store.item.password"
                              :feedback="false"
                              id="password"
                              name="account-password"
                              data-testid="account-password"
                              inputClass="w-full p-inputtext-sm"
                              placeholder="Password"
                              toggleMask
                    />
                </VhField>

                <VhField label="Display Name"
                         v-if="!store.isHidden('display_name')"
                         class="mb-2"
                >
                    <InputText class="w-full p-inputtext-sm"
                               v-model="store.item.display_name"
                               placeholder="Display Name"
                               name="account-display_name"
                               data-testid="account-display_name"
                    />
                </VhField>

                <template v-if="!store.isHidden('title')">
                    <VhField label="Title" class="mb-2">
                        <Dropdown class="w-full"
                                  placeholder="Title"
                                  v-model="store.item.title"
                                  :options="store.assets.name_titles"
                                  optionLabel="name"
                                  optionValue="slug"
                                  id="Title"
                                  inputClass="p-inputtext-sm"
                                  name="account-title"
                                  data-testid="account-title"
                                  :pt="{
                                      dropdownIcon: {
                                          style: {
                                              height: '0.7rem',
                                              width: '0.7rem'
                                          }
                                      }
                                  }"
                        />
                    </VhField>
                </template>

                <VhField label="Designation" v-if="!store.isHidden('designation')" class="mb-2">
                    <InputText class="w-full p-inputtext-sm"
                               placeholder="Designation"
                               v-model="store.item.designation"
                               name="account-designation"
                               data-testid="account-designation"
                    />
                </VhField>

                <VhField label="First Name" class="mb-2">
                    <InputText class="w-full p-inputtext-sm"
                               placeholder="First Name"
                               v-model="store.item.first_name"
                               name="account-first_name"
                               data-testid="account-first_name"
                    />
                </VhField>

                <VhField label="Middle Name" v-if="!store.isHidden('middle_name')" class="mb-2">
                    <InputText class="w-full p-inputtext-sm"
                               placeholder="Middle Name"
                               v-model="store.item.middle_name"
                               name="account-middle_name"
                               data-testid="account-middle_name"
                    />
                </VhField>

                <VhField label="Last Name" v-if="!store.isHidden('last_name')" class="mb-2">
                    <InputText class="w-full p-inputtext-sm"
                               placeholder="Last Name"
                               v-model="store.item.last_name"
                               name="account-last_name"
                               data-testid="account-last_name"
                    />
                </VhField>

                <VhField label="Gender" v-if="!store.isHidden('gender')" class="mb-2">
                    <SelectButton v-model="store.item.gender"
                                  :options="store.gender_options"
                                  class="shadow-none p-buttonset-sm"
                                  optionLabel="label"
                                  optionValue="value"
                                  aria-labelledby="custom"
                                  name="account-gender"
                                  data-testid="account-gender"
                    >
                        <template #option="slotProps">
                            <p>{{ slotProps.option.label }}</p>
                        </template>
                    </SelectButton>
                </VhField>

                <VhField label="Country" v-if="!store.isHidden('country')" class="mb-2">
                    <AutoComplete class="w-full"
                                  v-model="store.item.country"
                                  :suggestions="store.filtered_country_codes"
                                  @complete="store.searchCountryCode"
                                  @item-select="store.onSelectCountryCode"
                                  placeholder="Enter Your Country"
                                  optionLabel="name"
                                  name="account-country"
                                  data-testid="account-country"
                                  inputClass="w-full p-inputtext-sm"
                    />
                </VhField>

                <VhField label="Country Code" v-if="!store.isHidden('country_calling_code')"
                         class="mb-2">
                    <Dropdown class="w-full"
                              placeholder="Country Code"
                              inputClass="p-inputtext-sm"
                              v-model="store.item.country_calling_code"
                              :options="store.assets.countries"
                              :editable="true"
                              optionLabel="calling_code"
                              optionValue="calling_code"
                              id="calling_code"
                              name="account-country_calling_code"
                              data-testid="account-country_calling_code"
                              :pt="{
                                  dropdownIcon: {
                                      style: {
                                          height: '0.7rem',
                                          width: '0.7rem'
                                      }
                                  }
                              }"
                    />
                </VhField>

                <VhField label="Phone" v-if="!store.isHidden('phone')"
                         class="mb-2">
                    <InputText class="w-full p-inputtext-sm"
                               placeholder="Phone"
                               v-model="store.item.phone"
                               name="account-phone"
                               data-testid="account-phone"
                    />
                </VhField>

                <VhField label="Bio" v-if="!store.isHidden('bio')"
                         class="mb-2">
                    <Editor v-model="store.item.bio"
                            name="account-bio"
                            placeholder="Bio..."
                            data-testid="account-bio"
                    />
                </VhField>

                <VhField label="Website" v-if="!store.isHidden('website')"
                         class="mb-2">
                    <InputText class="w-full p-inputtext-sm"
                               placeholder="Website"
                               v-model="store.item.website"
                               name="account-website"
                               data-testid="account-website"
                    />
                </VhField>

                <VhField label="Timezone" v-if="!store.isHidden('timezone')"
                         class="mb-2">
                    <Dropdown v-model="store.item.timezone"
                              :options="store.assets.timezones"
                              optionLabel="name"
                              optionValue="slug"
                              :filter="true"
                              placeholder="Enter Your Timezone"
                              :showClear="true"
                              data-testid="account-timezone"
                              class="w-full"
                              inputClass="p-inputtext-sm"
                              :pt="{
                                  dropdownIcon: {
                                      style: {
                                          height: '0.7rem',
                                          width: '0.7rem'
                                      }
                                  }
                              }"
                    />
                </VhField>

                <VhField label="Alternate Email" v-if="!store.isHidden('alternate_email')"
                         class="mb-2">
                    <InputText class="w-full p-inputtext-sm"
                               placeholder="Alternate Email"
                               v-model="store.item.alternate_email"
                               name="account-alternate_email"
                               data-testid="account-alternate_email"
                    />
                </VhField>

                <VhField label="Date of Birth" v-if="!store.isHidden('birth')"
                         class="mb-2">
                    <Calendar class="w-full p-inputgroup"
                              id="dob"
                              inputId="basic"
                              v-model="store.item.birth"
                              autocomplete="off"
                              name="account-birth"
                              data-testid="account-birth"
                              dateFormat="mm-dd-yy"
                              placeholder="mm-dd-yy"
                              :showIcon="true"
                              :showTime="false"
                              :pt="{
                                  input: 'p-inputtext-sm',
                                  button: 'p-button-sm'
                              }"
                    />
                </VhField>

                <VhField label="Foreign User Id" v-if="!store.isHidden('foreign_user_id')"
                         class="mb-2">
                    <InputText class="w-full p-inputtext-sm"
                               placeholder="Foreign User Id"
                               type="number"
                               v-model="store.item.foreign_user_id"
                               name="account-foreign_user_id"
                               data-testid="account-foreign_user_id"
                    />
                </VhField>

                <VhField label="Status" class="mb-2">
                    <Dropdown class="w-full"
                              inputClass="p-inputtext-sm"
                              placeholder="Status"
                              v-model="store.item.status"
                              :options="store.status_options"
                              optionLabel="label"
                              optionValue="value"
                              id="account-status"
                              name="account-status"
                              data-testid="account-status"
                              @change="store.setIsActiveStatus"
                              :pt="{
                                  dropdownIcon: {
                                      style: {
                                          height: '0.7rem',
                                          width: '0.7rem'
                                      }
                                  }
                              }"
                    />
                </VhField>

                <VhField label="Is Active" class="mb-2">
                    <SelectButton v-if="root && root.is_active_status_options"
                                  v-model="store.item.is_active"
                                  :options="root.is_active_status_options"
                                  class="shadow-none p-buttonset-sm"
                                  option-label="label"
                                  option-value="value"
                    />
                </VhField>

                <template v-if="store.assets && store.assets.custom_fields"
                          v-for="(custom_field,key) in store.assets.custom_fields.value"
                          :key="key"
                >
                    <VhField :label="useVaah.toLabel(custom_field.name)"
                             v-if="!custom_field.is_hidden">
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
                                  :name=" 'account-meta_'+custom_field.slug"
                                  :data-testid="'account-meta_'+custom_field.slug"
                                  :min="custom_field.min"
                                  :max="custom_field.max"
                                  :minlength="custom_field.minlength"
                                  :maxlength="custom_field.maxlength"
                                  v-model="store.item.meta['custom_fields'][custom_field.slug]"
                                  toggleMask
                                  class="w-full"
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
