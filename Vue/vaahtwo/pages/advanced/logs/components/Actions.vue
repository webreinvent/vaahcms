<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import { useLogStore } from '../../../../stores/store-logs'

import Filters from './Filters.vue'

const store = useLogStore();

onMounted(async () => {
    store.getListSelectedMenu();
    store.getListBulkMenu();
});

//--------selected_menu_state
const selected_menu_state = ref();
const toggleSelectedMenuState = (event) => {
    selected_menu_state.value.toggle(event);
};
//--------/selected_menu_state

//--------bulk_menu_state
const bulk_menu_state = ref();
const toggleBulkMenuState = (event) => {
    bulk_menu_state.value.toggle(event);
};
//--------/bulk_menu_state
</script>

<template>
    <div>

        <!--actions-->
        <div class="p-inputgroup">
            <InputText placeholder="Enter Search Terms"/>
            <Button icon="pi pi-search" class="p-button-primary"/>
        </div>
        <!--/actions-->

    </div>
</template>
