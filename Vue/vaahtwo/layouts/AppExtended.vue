<script setup>
    import {onMounted, reactive} from "vue";

    import {vaah} from '../vaahvue/pinia/vaah.js'
    import {useRootStore} from '../stores/root.js'

    import { useToast } from "openvue/usetoast";
    import { useConfirm } from "openvue/useconfirm";

    const toast = useToast();
    const confirm = useConfirm();
    const useVaah = vaah();
    const root = useRootStore();

    useVaah.setToast(toast);
    useVaah.setConfirm(confirm);

    // M3-T4 (F12) — v4 ConfirmDialog `#message` slot tint: the removed v3
    // accept-button class string is gone; the only surviving per-dialog
    // icon/message tint is a bare colour word carried in the v4 accept-button
    // props object (e.g. { class: 'yellow' }), mapped to the token-backed
    // PrimeFlex text-<colour>-500 utility. Class strings and severity-only
    // objects carry no tint (their v3 interpolations were inert classes).
    function confirmTintClass(message)
    {
        const cls = message && message.acceptProps ? message.acceptProps.class : null;
        return (typeof cls === 'string' && /^[a-z]+$/i.test(cls))
            ? 'text-' + cls.toLowerCase() + '-500'
            : null;
    }


    import TopnavExtended from "../components/molecules/TopnavExtended.vue";
    import Sidebar from "../components/molecules/Sidebar.vue";


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

        <Toast position="top-center" >
            <template #message="slotProps">
                <!-- UT-101 (M6-T4a Batch 22) — see App.vue: the custom
                     message template has to keep the message growing, or
                     the dismiss button lands next to the text instead of
                     in the toast's corner. -->
                <div class="vaah-toast-text">
                    <span v-if="slotProps.message.summary"
                          v-html="slotProps.message.summary"></span>
                    <div v-if="slotProps.message.detail"
                         v-html="slotProps.message.detail">
                    </div>
                </div>
            </template>
        </Toast>

        <ConfirmDialog :style="{width: '40vw'}">
            <template #message="slotProps">

                <i v-if="slotProps.message.icon"
                   :class="[slotProps.message.icon, confirmTintClass(slotProps.message)]"></i>
                <span :class="confirmTintClass(slotProps.message)"
                      v-html="slotProps.message.message">
                </span>
            </template>
        </ConfirmDialog>
        <!--/default-->


        <!-- M6 (F31): the id (not just the class) is what the persistent-nav
             shell scss targets — `#nav-shell .sidebar` / `#nav-shell.nav-collapsed
             .sidebar` in style.scss. The retired id (topmenu-and-sidebar-container)
             matched no rule, so toggling nav-collapsed had no visual effect here.
             Only one of Backend.vue / AppExtended.vue is mounted per page
             (default.blade.php vs backend.blade.php), so the shared id is safe. -->
        <div id="nav-shell" v-if="rootStore.is_logged_in"
        :class="['nav-shell', { 'nav-collapsed': rootStore.sidebar_collapsed }]">

            <TopnavExtended />

            <Sidebar/>


        </div>

        <!--            <Footer />-->
    </div>
</template>
