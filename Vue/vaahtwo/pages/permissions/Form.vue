<script setup>
import {onMounted, ref, watch} from "vue";
import { usePermissionStore } from '../../stores/store-permissions';
import { vaah } from '../../vaahvue/pinia/vaah';
import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import {useRoute} from 'vue-router';


const store = usePermissionStore();
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

    <div class="col-5">
        <Panel>
            <template class="p-1" #header>
                <div class="flex flex-row">
                    <div class="p-panel-title text-sm">
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
                            class="p-button-outlined p-button-sm"
                            :label=" '#' + store.item.id"
                            @click="useVaah.copy(store.item.id)"
                    />

                    <Button v-if="store.item && store.item.id"
                            class="p-button-outlined p-button-sm"
                            label="Save"
                            icon="pi pi-save"
                            @click="store.itemAction('save')"
                    />

                    <Button v-else
                            class="p-button-outlined p-button-sm"
                            label="Create & New"
                            icon="pi pi-save"
                            @click="store.itemAction('create-and-new')"
                    />

                    <Button v-if="store.item && store.item.id"
                            class="p-button-outlined p-button-sm"
                            icon="pi pi-eye"
                            v-tooltip.top="'View'"
                            @click="store.toView(store.item)"
                    />

                    <!--form_menu-->
                    <Button class="p-button-outlined p-button-sm"
                            icon="pi pi-angle-down"
                            aria-haspopup="true"
                            type="button"
                            @click="toggleFormMenu"
                    />

                    <Menu ref="form_menu"
                          :model="store.form_menu_list"
                          :popup="true"
                    />
                    <!--/form_menu-->

                    <Button class="p-button-sm"
                            icon="pi pi-times"
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
