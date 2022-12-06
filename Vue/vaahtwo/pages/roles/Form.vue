<script setup>
import {onMounted, ref, watch} from "vue";
import {useRoleStore} from '../../stores/store-roles'

import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import {useRoute} from 'vue-router';


const store = useRoleStore();
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
                            :label=" '#' + store.item.id "
                            icon="pi pi-save"
                            @click="store.itemAction('save')"
                    />

                    <Button v-if="store.item && store.item.id"
                            label="Save"
                            icon="pi pi-save"
                            @click="store.itemAction('save')"
                    />

                    <Button v-else
                            label="Create & New"
                            icon="pi pi-save"
                            @click="store.itemAction('create-and-new')"
                    />

                    <!--form_menu-->
                    <Button icon="pi pi-angle-down"
                            type="button"
                            aria-haspopup="true"
                            @click="toggleFormMenu"
                    />

                    <Menu ref="form_menu"
                          :model="store.form_menu_list"
                          :popup="true"
                    />
                    <!--/form_menu-->

                    <Button v-if="store.item && store.item.id"
                            icon="pi pi-eye"
                            v-tooltip.top="'View'"
                            @click="store.toView(store.item)"
                    />

                    <Button icon="pi pi-times"
                            @click="store.toList()"
                    />
                </div>



            </template>


            <div v-if="store.item">

                <VhField label="Name">
                    <InputText class="w-full" v-model="store.item.name" />
                </VhField>

                <VhField label="Slug">
                    <InputText class="w-full" v-model="store.item.slug" />
                </VhField>

                <VhField label="Details">
                    <Textarea class="w-full" v-model="store.item.details" />
                </VhField>

                <VhField label="Is Active">
                    <InputSwitch v-bind:false-value="0"
                                 v-bind:true-value="1"
                                 v-model="store.item.is_active"
                    />
                </VhField>

            </div>
        </Panel>

    </div>

</template>
