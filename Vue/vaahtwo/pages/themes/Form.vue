<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import {onMounted, ref, watch} from "vue";
import { useThemeStore } from '../../stores/store-themes'

import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import {useRoute} from 'vue-router';


const store = useThemeStore();
const route = useRoute();

onMounted(async () => {
    if(route.params && route.params.id)
    {
        await store.getItem(route.params.id);
    }

    await store.watchItem();
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


                <InputGroup>
                    <Button label="Save"
                            v-if="store.item && store.item.id"
                            data-testid="themes-save"
                            @click="store.itemAction('save')"
                            icon="pi pi-save"/>

                    <Button label="Create & New"
                            v-else
                            @click="store.itemAction('create-and-new')"
                            data-testid="themes-create-and-new"
                            icon="pi pi-save"/>


                    <!--form_menu-->
                    <Button aria-label="Show actions menu"
                        type="button"
                        @click="toggleFormMenu"
                        data-testid="themes-form-menu"
                        icon="pi pi-angle-down"
                        aria-haspopup="true"/>

                    <Menu ref="form_menu"
                          :model="store.form_menu_list"
                          :popup="true" />
                    <!--/form_menu-->


                    <Button aria-label="Back to list" class="p-button-primary"
                            icon="pi pi-times"
                            data-testid="themes-to-list"
                            @click="store.toList()">
                    </Button>
                </InputGroup>



            </template>


            <div v-if="store.item">

                <VhField label="Name">
                    <InputText class="w-full"
                               name="themes-name"
                               data-testid="themes-name"
                               v-model="store.item.name"/>
                </VhField>

                <VhField label="Slug">
                    <InputText class="w-full"
                               name="themes-slug"
                               data-testid="themes-slug"
                               v-model="store.item.slug"/>
                </VhField>

                <VhField label="Is Active">
                    <ToggleSwitch v-bind:false-value="0"
                                 v-bind:true-value="1"
                                 name="themes-active"
                                 data-testid="themes-active"
                                 v-model="store.item.is_active"/>
                </VhField>

            </div>
        </Panel>

    </div>

</template>
