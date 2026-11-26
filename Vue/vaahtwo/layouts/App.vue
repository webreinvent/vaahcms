<script setup>
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
</script>


<template>
    <div>

        <ProgressBar style="z-index: 10000000; position: fixed; top: 1px; width: 100%; left: 0px; height: 2px;"
                     v-if="useVaah.show_progress_bar"
                     mode="indeterminate"/>

        <Toast position="top-center" >
            <template #message="slotProps">
                <!-- UT-101 (M6-T4a Batch 22) — the custom message template
                     replaced the engine's own `.p-toast-message-text`
                     wrapper, which is the element the engine gives
                     `flex: 1 1 auto`. Without it the message did not grow,
                     so the dismiss button sat right next to the text
                     instead of in the toast's corner, and the engine's
                     size-relative nudge pushed the X off the text's
                     centre line. The wrapper restores the growth. -->
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
        <RouterView />
    </div>
</template>
