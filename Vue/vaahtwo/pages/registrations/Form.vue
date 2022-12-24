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

                <VhField v-if="store.item && store.item.id" label="New Password">
                    <Password  class="w-full" v-model="store.item.password" :feedback="false" toggleMask>
                    </Password  >
                </VhField>
                <VhField v-else label="Password">
                    <Password  class="w-full" v-model="store.item.password" :feedback="false" toggleMask>
                    </Password  >
                </VhField>


                <VhField label="Display Name">
                    <InputText class="w-full" v-model="store.item.display_name">
                    </InputText >
                </VhField>

                <VhField label="Title">
                    <Dropdown v-model="store.item.title"
                              :options="store.assets.name_titles"
                              optionLabel="name"
                              optionValue="slug"
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
                        <RadioButton inputId="male"
                                     name="gender"
                                     value="M"
                                     v-model="store.item.gender" />
                        <label for="male">Male</label>
                        <RadioButton inputId="female"
                                     name="gender"
                                     value="F"
                                     v-model="store.item.gender" />
                        <label for="female">Female</label>

                        <RadioButton inputId="other"
                                     name="other"
                                     value="O"
                                     v-model="store.item.gender" />
                        <label for="other">Other</label>


                </VhField>



<!--                <VhField label="Country">

                      <Dropdown v-model="store.item.country"
                              :options="store.assets.countries"
                              optionLabel="name"
                              optionValue="name"
                              :filter="true"
                              placeholder="- Select a country -"
                              :showClear="true">
                    </Dropdown>
                </VhField>-->

<!--                <VhField label="Country Code">

                      <Dropdown v-model="store.item.country_code"
                              :options="store.assets.countries"
                              optionLabel="code"
                              optionValue="code"
                              :filter="true"
                              placeholder="- Select Country code -"
                              :showClear="true">
                    </Dropdown>
                </VhField>-->


                <VhField label="Country Code">
                    <Dropdown v-model="store.item.country_calling_code"
                              :options="store.assets.country_calling_code"
                              optionLabel='calling_code'
                              optionValue='calling_code'
                              placeholder="- Select a country code -" >
                    </Dropdown>
                </VhField>




                <VhField label="Phone">
                    <InputNumber inputId="withoutgrouping" v-model="store.item.phone"  :useGrouping="false" />
                </VhField>

                <VhField label="Bio">
                    <Textarea v-model="store.item.bio" :autoResize="true" rows="5" cols="30" />
                </VhField>

                <VhField label="Timezone">

                    <Dropdown v-model="store.item.timezone"
                              :options="store.assets.timezones"
                              optionLabel="name"
                              optionValue="slug"
                              :filter="true"
                              placeholder="- Select a title -"
                              :showClear="true">
                    </Dropdown>

                </VhField>


                <VhField label="Alternate Email">
                    <InputText class="w-full"
                               v-model="store.item.alternate_email">
                    </InputText >
                </VhField>

                <VhField label="Date of Birth">
                    <Calendar inputId="dateformat"
                              v-model="store.item.birth"
                              :showIcon="true"
                              dateFormat="mm-dd-yy" />
                </VhField>

                <VhField label="Country">
                      <Dropdown v-model="store.item.country"
                              :options="store.assets.countries"
                              optionLabel="name"
                              optionValue="name"
                              :filter="true"
                              placeholder="- Select a country -"
                              :showClear="true">
                    </Dropdown>
                </VhField>



                <VhField label="Status">
                    <Dropdown v-model="store.item.status"
                              :options="store.assets.registration_statuses"
                              optionLabel="name"
                              optionValue="slug"
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
