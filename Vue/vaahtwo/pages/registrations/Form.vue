<script setup>
import {onMounted, ref, watch} from "vue";
import { useRegistrationStore } from '../../stores/store-registrations'

import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import {useRoute} from 'vue-router';


const store = useRegistrationStore();
const route = useRoute();

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

    <div class="col-4" >

        <Panel >
            <Message severity="error"
                         class="p-container-message"
                         :closable="false"
                         icon="pi pi-trash"
                         v-if="store.item && store.item.deleted_at">

                    <div class="flex align-items-center justify-content-between">

                        <div class="">
                            Deleted {{store.item.deleted_at}}
                        </div>

                        <div class="">
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
                            Update
                        </span>
                        <span v-else>
                            Create
                        </span>
                    </div>

                </div>


            </template>

            <template #icons>


                <div class="p-inputgroup">
                    <Button label="Save"
                            v-if="store.item && store.item.id"
                            @click="store.itemAction('save')"
                            icon="pi pi-save"
                            data-testid="register-form_item_action_save"
                    />

                    <Button label="Create & New"
                            v-else
                            @click="store.itemAction('create-and-new')"
                            icon="pi pi-save"
                            data-testid="register-form_item_action_create_and_new"
                    />


                    <!--form_menu-->
                    <Button
                        type="button"
                        @click="toggleFormMenu"
                        icon="pi pi-angle-down"
                        aria-haspopup="true"
                        data-testid="register-form_toggle_form_menu_list"
                    />

                    <Menu ref="form_menu"
                          :model="store.form_menu_list"
                          :popup="true" />
                    <!--/form_menu-->


                    <Button class="p-button-primary"
                            icon="pi pi-times"
                            @click="store.toList()"
                            data-testid="register-form_to_list"
                    >
                    </Button>
                </div>
            </template>


            <div v-if="store.item && store.assets">




                <VhField label="Email">
                    <InputText class="w-full"
                               v-model="store.item.email"
                               name="register-email"
                               data-testid="register-email"

                    >
                    </InputText >
                </VhField>

                <VhField label="Username">
                    <InputText class="w-full"
                               v-model="store.item.username"
                               name="register-username"
                               data-testid="register-username"
                    >
                    </InputText >
                </VhField>

                <VhField v-if="store.item && store.item.id" label="New Password">
                    <Password  class="w-full"
                               v-model="store.item.password"
                               :feedback="false"
                               toggleMask
                               name="register-password"
                               data-testid="register-password"
                    >
                    </Password  >
                </VhField>
                <VhField v-else label="Password">
                    <Password  class="w-full"
                               v-model="store.item.password"
                               :feedback="false"
                               toggleMask
                               name="register-password"
                               data-testid="register-password"
                    >
                    </Password  >
                </VhField>


                <VhField label="Display Name">
                    <InputText class="w-full"
                               v-model="store.item.display_name"
                               name="register-display_name"
                               data-testid="register-display_name"
                    >
                    </InputText >
                </VhField>

                <VhField label="Title">
                    <Dropdown v-model="store.item.title"
                              :options="store.assets.name_titles"
                              optionLabel="name"
                              optionValue="slug"
                              placeholder="- Select a title -"
                              data-testid="register-title"
                    />
                </VhField>

                <VhField label="Designation">
                    <InputText class="w-full"
                               v-model="store.item.designation"
                               name="register-designation"
                               data-testid="register-designation"
                    >
                    </InputText >
                </VhField>


                <VhField label="First Name">
                    <InputText class="w-full"
                               v-model="store.item.first_name"
                               name="register-first_name"
                               data-testid="register-first_name"
                    >
                    </InputText >
                </VhField>
                <VhField label="Middle Name">
                    <InputText class="w-full"
                               v-model="store.item.middle_name"
                               name="register-middle_name"
                               data-testid="register-middle_name"
                    >
                    </InputText >
                </VhField>

                <VhField label="Last Name">
                    <InputText class="w-full"
                               v-model="store.item.last_name"
                               name="register-last_name"
                               data-testid="register-last_name"
                    >
                    </InputText >
                </VhField>

                <VhField label="Gender">
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

                <VhField label="Country Code">
                    <Dropdown v-model="store.item.country_calling_code"
                              :options="store.assets.country_calling_code"
                              optionLabel='calling_code'
                              optionValue='calling_code'
                              placeholder="- Select a country code -"
                              data-testid="register-country_calling_code"
                    >
                    </Dropdown>
                </VhField>

                <VhField label="Phone">
                    <InputNumber inputId="withoutgrouping"
                                 v-model="store.item.phone"
                                 :useGrouping="false"
                                 name="register-phone"
                                data-testid="register-phone"
                    />
                </VhField>

                <VhField label="Bio">
                    <Textarea v-model="store.item.bio"
                              :autoResize="true"
                              rows="5"
                              cols="30"
                              name="register-bio"
                              data-testid="register-bio"
                    />
                </VhField>

                <VhField label="Timezone">

                    <Dropdown v-model="store.item.timezone"
                              :options="store.assets.timezones"
                              optionLabel="name"
                              optionValue="slug"
                              :filter="true"
                              placeholder="- Select a title -"
                              :showClear="true"
                              data-testid="register-timezone"
                    >
                    </Dropdown>

                </VhField>


                <VhField label="Alternate Email">
                    <InputText class="w-full"
                               v-model="store.item.alternate_email"
                               name="register-alternate_email"
                               data-testid="register-alternate_email"
                    >
                    </InputText >
                </VhField>

                <VhField label="Date of Birth">
                    <Calendar inputId="dateformat"
                              v-model="store.item.birth"
                              :showIcon="true"
                              dateFormat="mm-dd-yy"
                              data-testid="register-birth"
                    />
                </VhField>

                <VhField label="Country">
                      <Dropdown v-model="store.item.country"
                              :options="store.assets.countries"
                              optionLabel="name"
                              optionValue="name"
                              :filter="true"
                              placeholder="- Select a country -"
                              :showClear="true"
                               data-testid="register-country"
                      >
                    </Dropdown>
                </VhField>



                <VhField label="Status">
                    <Dropdown v-model="store.item.status"
                              :options="store.assets.registration_statuses"
                              optionLabel="name"
                              optionValue="slug"
                              placeholder="- Select a status -"
                              data-testid="register-status"
                    />
                </VhField>


            </div>
        </Panel>

    </div>

</template>
