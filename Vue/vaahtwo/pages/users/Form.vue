<script setup>
import {onMounted, ref, watch} from "vue";
import { useUserStore } from '../../stores/store-users'
import { useRootStore } from '../../stores/root'

import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import {useRoute} from 'vue-router';


const store = useUserStore();
const root = useRootStore();
const route = useRoute();

onMounted(async () => {
    if (route.params && route.params.id) {
        await store.getItem(route.params.id);
    }

    store.getFormMenu();

    root.getIsActiveStatusOptions();
});

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
        <Panel >
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
                    <Button label="Save"
                            v-if="store.item && store.item.id"
                            @click="store.itemAction('save')"
                            icon="pi pi-save"/>

                    <Button label="Create & New"
                            v-else
                            @click="store.itemAction('create-and-new')"
                            icon="pi pi-save"/>


                    <!--form_menu-->
                    <Button
                        type="button"
                        @click="toggleFormMenu"
                        icon="pi pi-angle-down"
                        aria-haspopup="true"/>

                    <Menu ref="form_menu"
                          :model="store.form_menu_list"
                          :popup="true" />
                    <!--/form_menu-->

                    <Button v-if="store.item && store.item.id"
                            class="p-button-sm"
                            icon="pi pi-eye"
                            v-tooltip.top="'View'"
                            @click="store.toView(store.item)"
                    />

                    <Button class="p-button-primary"
                            icon="pi pi-times"
                            @click="store.toList()">
                    </Button>
                </div>



            </template>


            <div v-if="store.item && store.assets">
                <div class="field mb-4 flex justify-content-between align-items-center" v-if="root && root.assets">
                    <img
                        src="https://img.site/p/100/100/BDC3C8/solid-box"
                        alt=""
                        width="64"
                        height="64"
                        style="border-radius: 50%">
                    <FileUpload
                        mode="basic"
                        name="demo[]"
                        :url="root.assets.urls.upload"
                        accept="image/*"
                        :maxFileSize="1000000"
                        @upload="store.onUpload"
                        @uploader="myUploader"/>
                </div>
                <VhField label="Email">
                    <InputText
                        class="w-full"
                        v-model="store.item.email"
                        name="account-email"
                        data-testid="account-email">
                    </InputText >
                </VhField>

                <VhField label="Username">
                    <InputText
                        class="w-full"
                        v-model="store.item.username"
                        name="account-username"
                        data-testid="account-username">
                    </InputText >
                </VhField>

                <VhField label="Password">
                    <Password
                        v-model="store.item.password"
                        :feedback="false"
                        id="password"
                        class="w-full"
                        name="account-password"
                        data-testid="account-password"/>
                </VhField>

                <VhField label="Display Name">
                    <InputText
                        class="w-full"
                        v-model="store.item.display_name"
                        name="account-display_name"
                        data-testid="account-display_name">
                    </InputText >
                </VhField>

                <VhField label="Title">
                    <Dropdown
                        v-model="store.item.title"
                        :options="store.assets.name_titles"
                        optionLabel="name"
                        optionValue="slug"
                        id="Title"
                        class="w-full"
                        name="account-title"
                        data-testid="account-title"/>
                </VhField>

                <VhField label="Designation">
                    <InputText
                        class="w-full"
                        v-model="store.item.designation"
                        name="account-designation"
                        data-testid="account-designation">
                    </InputText >
                </VhField>

                <VhField label="First Name">
                    <InputText
                        class="w-full"
                        v-model="store.item.first_name"
                        name="account-first_name"
                        data-testid="account-first_name">
                    </InputText >
                </VhField>

                <VhField label="Middle Name">
                    <InputText
                        class="w-full"
                        v-model="store.item.middle_name"
                        name="account-middle_name"
                        data-testid="account-middle_name">
                    </InputText >
                </VhField>

                <VhField label="Last Name">
                    <InputText
                        class="w-full"
                        v-model="store.item.last_name"
                        name="account-last_name"
                        data-testid="account-last_name">
                    </InputText >
                </VhField>

                <VhField label="Gender">
                    <SelectButton
                        v-model="store.item.gender"
                        :options="store.gender_options"
                        optionLabel="label"
                        optionValue="value"
                        aria-labelledby="custom"
                        name="account-gender"
                        data-testid="account-gender">
                        <template #option="slotProps">
                            <p>{{slotProps.option.label}}</p>
                        </template>
                    </SelectButton>
                </VhField>

                <VhField label="Country Code">
                    <Dropdown
                        v-model="store.item.country_calling_code"
                        :options="store.assets.countries"
                        :editable="true"
                        optionLabel="calling_code"
                        optionValue="calling_code"
                        id="calling_code"
                        class="w-full"
                        name="account-country_calling_code"
                        data-testid="account-country_calling_code"/>
                </VhField>

                <VhField label="Phone">
                    <InputText
                        class="w-full"
                        v-model="store.item.phone"
                        name="account-phone"
                        data-testid="account-phone">
                    </InputText >
                </VhField>

                <VhField label="bio">
                    <Editor
                        v-model="store.item.bio"
                        editorStyle="height: 320px"
                        name="account-bio"
                        data-testid="account-bio"/>
                </VhField>

                <VhField label="Website">
                    <InputText
                        class="w-full"
                        v-model="store.item.website"
                        name="account-website"
                        data-testid="account-website">
                    </InputText >
                </VhField>

                <VhField label="Timezone">
                    <AutoComplete
                        v-model="store.item.timezone"
                        :suggestions="store.filtered_timezone_codes"
                        @complete="store.searchTimezoneCode"
                        @item-select="store.onSelectTimezoneCode"
                        placeholder="Enter Your Timezone"
                        optionLabel="name"
                        class="w-full"
                        name="account-timezone"
                        data-testid="account-timezone"/>
                </VhField>

                <VhField label="Alternate Email">
                    <InputText
                        class="w-full"
                        v-model="store.item.alternate_email"
                        name="account-alternate_email"
                        data-testid="account-alternate_email">
                    </InputText >
                </VhField>

                <VhField label="Date of Birth">
                    <Calendar
                        id="dob"
                        inputId="basic"
                        v-model="store.item.birth"
                        autocomplete="off"
                        class="w-full"
                        name="account-birth"
                        data-testid="account-birth"/>
                </VhField>

                <VhField label="Country">
                    <AutoComplete
                        v-model="store.item.country"
                        :suggestions="store.filtered_country_codes"
                        @complete="store.searchCountryCode"
                        @item-select="store.onSelectCountryCode"
                        placeholder="Enter Your Country"
                        optionLabel="name"
                        name="account-country"
                        data-testid="account-country"
                        class="w-full"/>
                </VhField>

                <VhField label="Foreign User Id">
                    <InputText
                        type="number"
                        class="w-full"
                        v-model="store.item.foreign_user_id"
                        name="account-foreign_user_id"
                        data-testid="account-foreign_user_id">
                    </InputText >
                </VhField>

                <VhField label="Status">
                    <Dropdown
                        v-model="store.item.status"
                        :options="store.status_options"
                        optionLabel="label"
                        optionValue="value"
                        id="country-code"
                        class="w-full"
                        name="account-status"
                        data-testid="account-status"/>
                </VhField>

                <VhField label="Is Active">
                    <SelectButton v-if="root && root.is_active_status_options"
                                  v-model="store.item.is_active"
                                  :options="root.is_active_status_options"
                                  option-label="label"
                                  option-value="value"
                    />
                </VhField>

            </div>
        </Panel>

    </div>

</template>
