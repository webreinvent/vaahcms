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

    <div class="col-6" >

        <Panel >

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


                    <Button class="p-button-primary"
                            icon="pi pi-times"
                            @click="store.toList()">
                    </Button>
                </div>



            </template>


            <div v-if="store.item">

                <VhField label="Email">
                    <InputText class="w-full" v-model="store.item.email">
                    </InputText >
                </VhField>

                <VhField label="Username">
                    <InputText class="w-full" v-model="store.item.username">
                    </InputText >
                </VhField>

                <VhField label="Password">
                    <Password  class="w-full" v-model="store.item.password">
                    </Password  >
                </VhField>


                <VhField label="Display Name">
                    <InputText class="w-full" v-model="store.item.display_name">
                    </InputText >
                </VhField>

                <VhField label="Title">
                    <Dropdown v-model="store.item.title"
                              :options="cities"
                              placeholder="- Select a title -" />
                </VhField>

                <VhField label="Designation">
                    <InputText class="w-full" v-model="store.item.designation">
                    </InputText >
                </VhField>

                <VhField label="First Name">
                    <InputText class="w-full" v-model="store.item.first_name">
                    </InputText >
                </VhField>
                <VhField label="Middle Name">
                    <InputText class="w-full" v-model="store.item.middle_name">
                    </InputText >
                </VhField>

                <VhField label="Last Name">
                    <InputText class="w-full" v-model="store.item.last_name">
                    </InputText >
                </VhField>

                 <VhField label="Gender">
                    <Dropdown v-model="store.item.gender"
                              :options="gender"
                              placeholder="- Select your gender -" />
                </VhField>

                <VhField label="Country Code">
                    <Dropdown v-model="store.item.country_calling_code"
                              :options="country_calling_code"
                              placeholder="- Select a country code -" />
                </VhField>
                <VhField label="Phone">
                    <InputNumber inputId="withoutgrouping" v-model="store.item.phone"  :useGrouping="false" />
                </VhField>

                <VhField label="Bio">
                    <Textarea v-model="store.item.bio" :autoResize="true" rows="5" cols="30" />
                </VhField>

                <VhField label="Timezone">
                    <AutoComplete v-model="store.item.timezone"
                                  @complete="searchCountry($event)"
                                  optionLabel="name" />
                </VhField>

                <VhField label="Alternate Email">
                    <InputText class="w-full"
                               v-model="store.item.alternate_email">
                    </InputText >
                </VhField>

                <VhField label="Date of Birth">
                    <Calendar inputId="dateformat"
                              v-model="store.item.birth"
                              dateFormat="mm-dd-yy" />
                </VhField>

                 <VhField label="Country">
                    <AutoComplete v-model="store.item.country"
                                  @complete="searchCountry($event)"
                                  optionLabel="name" />
                </VhField>

                <VhField label="Status">
                    <Dropdown v-model="store.item.status"
                              :options="registration_statuses"
                              placeholder="- Select a status -" />
                </VhField>





<!--                <VhField label="Is Active">
                    <InputSwitch v-bind:false-value="0"
                                 v-bind:true-value="1"
                                 v-model="store.item.is_active">
                    </InputSwitch>
                </VhField>-->

            </div>
        </Panel>

    </div>

</template>
