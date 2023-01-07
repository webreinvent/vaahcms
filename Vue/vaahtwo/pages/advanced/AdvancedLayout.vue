<script setup>
import {onMounted, ref, watch} from "vue";
import {useRoute} from 'vue-router';

import {useSettingStore} from '../../stores/store-settings';
import { vaah } from '../../vaahvue/pinia/vaah';

import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';
const store = useSettingStore();
const route = useRoute();
const useVaah = vaah();

const sidebar_menu_items = ref([
    {
        label: 'ADVANCED',
        items: [
            {
                label: 'Logs',
                icon: 'pi pi-book',
                command: () => {
                    this.$router.push({ path: '/vaah/settings/general' });
                }
            },
            {
                label: 'Jobs',
                icon: 'pi pi-align-justify',
                command: () => {
                    this.$router.push({ path: '/vaah/settings/user-settings' });
                }
            },
            {
                label: 'Failed Jobs',
                icon: 'pi pi-times-circle',
                command: () => {
                    this.$router.push({ path: '/vaah/settings/env-variables' });
                }
            },
            {
                label: 'Batches',
                icon: 'pi pi-server',
                command: () => {
                    this.$router.push({ path: '/vaah/settings/localization' });
                }
            }
        ]},
]);

onMounted(async () => {

    store.getGeneralAssets();

});

</script>

<template>
    <div class="grid justify-content-center">
        <div class="col-fixed">
            <Menu :model="sidebar_menu_items" />
        </div>
        <div class="col">
            <router-view></router-view>
        </div>
    </div>
</template>

<style scoped>

</style>
