<script setup>
    import {onMounted, reactive} from "vue";

    import {vaah} from '../vaahvue/pinia/vaah.js'
    import {useRootStore} from '../stores/root.js'

    import { useToast } from "primevue/usetoast";
    import { useConfirm } from "primevue/useconfirm";

    const toast = useToast();
    const confirm = useConfirm();
    const useVaah = vaah();
    const root = useRootStore();

    useVaah.setToast(toast);
    useVaah.setConfirm(confirm);


    import Aside from '../components/molecules/Aside.vue';

    import TopnavExtended from "../components/molecules/TopnavExtended.vue";
    import Footer from "../components/organisms/Footer.vue";
    import Sidebar from "../components/molecules/Sidebar.vue";
    import Notices from '../components/molecules/Notices.vue'


    const rootStore = useRootStore();


    onMounted(async () => {
        await rootStore.checkLoggedIn();
        await rootStore.getAssets();
        await rootStore.getPermission();
    });



</script>


<template>
    <div id="app-extend">

        <!--default-->
        <ProgressBar style="z-index: 10000000; position: fixed; top: 1px; width: 100%; left: 0px; height: 2px;"
                     v-if="useVaah.show_progress_bar"
                     mode="indeterminate"/>

        <Toast class="p-container-toasts" position="top-center" >
            <template #message="slotProps">
                <div class="p-toast-message-text">
                    <span class="p-toast-summary" v-if="slotProps.message.summary"
                          v-html="slotProps.message.summary"></span>
                    <div class="p-toast-detail" v-if="slotProps.message.detail"
                         v-html="slotProps.message.detail">
                    </div>
                </div>
            </template>
        </Toast>

        <ConfirmDialog :style="{width: '40vw'}"
                       class="p-container-confirm-dialog text-red-200">
            <template #message="slotProps">

                <i :class="slotProps.message.icon+' text-'+slotProps.message.acceptClass+'-500'"
                   class="p-confirm-dialog-icon "></i>
                <span :class="'text-'+slotProps.message.acceptClass+'-500'"
                      class="p-confirm-dialog-message"
                      v-html="slotProps.message.message">
                </span>
            </template>
        </ConfirmDialog>
        <!--/default-->


        <div id="topmenu-and-sidebar-container" v-if="rootStore.is_logged_in">

            <TopnavExtended />

            <Sidebar/>


        </div>
        
        <!--            <Footer />-->
    </div>
</template>
