<script setup>
import {onMounted, reactive, ref} from "vue";

import { useRootStore } from '../../stores/root'

const root = useRootStore();

// F06 / R5.9 — dismissals of the hook-failure notification are client-side,
// per session: the server keeps reporting a failure until the admin sees
// it (data.failed is not forgotten on read), and this dismiss state is what
// removes it from the UI. Stored in localStorage (keyed by slug + time) so
// a full page reload keeps the dismissal, while a NEW occurrence of the
// same failure (new server timestamp) re-appears.
const DISMISSAL_STORAGE_KEY = 'vaah.hook-failures.dismissed';

function read_dismissals() {
    try {
        const raw = window.localStorage.getItem(DISMISSAL_STORAGE_KEY);
        const list = raw ? JSON.parse(raw) : [];
        return Array.isArray(list) ? list : [];
    } catch (e) {
        return [];
    }
}

const dismissed_hook_failures = ref(read_dismissals());

function dismiss_hook_failure(slug, time) {
    const key = slug + ':' + time;
    if (!dismissed_hook_failures.value.includes(key)) {
        dismissed_hook_failures.value.push(key);
    }
    try {
        window.localStorage.setItem(DISMISSAL_STORAGE_KEY, JSON.stringify(dismissed_hook_failures.value));
    } catch (e) {
        // storage unavailable (private mode) — dismissal stays per mount
    }
}

function is_hook_failure_dismissed(slug, time) {
    return dismissed_hook_failures.value.includes(slug + ':' + time);
}
</script>

<template>
<!--    <div v-if="root &&-->
<!--    root.assets &&-->
<!--    root.assets.vue_notices &&-->
<!--    root.assets.vue_notices.length > 0" v-for="notice in root.assets.vue_notices">-->
<!--        <Message >-->
<!--            <span></span>-->
<!--            {{notice.meta.message}}-->
<!--            <Button :label="notice.meta.action.label"-->

<!--                    class="p-button-secondary"/>-->
<!--        </Message>-->
<!--    </div>-->

        <div v-if="root &&
        root.assets &&
        root.assets.vue_notices &&
        root.assets.vue_notices.length > 0" v-for="notice in root.assets.vue_notices">
            <div v-for="notice in root.assets.vue_notices">
                <div class="vc-notice-info flex justify-content-between mb-5 p-3">
<!--                    <div class="font-bold ml-1">🔥 Hot Deals!</div>-->
                    <div class="col-9 align-items-center hidden lg:flex ">
                        <span class="line-height-3 mr-2"><i class="pi pi-info-circle"></i></span>
                        <span class="line-height-3">{{notice.meta.message}}</span>
                    </div>
                    <div class="">
                        <Button :label="notice.meta.action.label"
                                data-testid="notice-goto_update"
                                @click="root.markAsRead(notice)"
                                class="p-button-raised p-button-primary mr-2"/>
                        <Button icon="pi pi-times-circle" aria-label="Dismiss notice"
                                @click="root.markAsRead(notice,true)"
                                data-testid="notice-mark_as_read"
                                class="p-button-rounded p-button-text p-button-info"/>
                    </div>

                </div>
            </div>
        </div>

        <!--
            F06 / R5.9 — hook-failure notifications: `data.failed` (keyed by
            slug) carries the vh_action failures collected in the session.
            Each band names the failing module/theme and the exception
            message; the dismiss control is client-side (dismissed_hook_failures).
        -->
        <div v-for="failure in (root && root.assets && root.assets.failed
            ? Object.entries(root.assets.failed) : [])"
             :key="failure[0]">
            <div v-if="!is_hook_failure_dismissed(failure[0], failure[1].time)"
                 class="vc-notice-error flex justify-content-between mb-5 p-3"
                 data-testid="hook-failure-notification">
                <div class="col-9 align-items-center hidden lg:flex">
                    <span class="line-height-3 mr-2"><i class="pi pi-exclamation-triangle"></i></span>
                    <span class="line-height-3">{{ failure[0] }} — {{ failure[1].source }} hook
                        "{{ failure[1].method }}" failed: {{ failure[1].message }}</span>
                </div>
                <div class="">
                    <Button icon="pi pi-times-circle" aria-label="Dismiss notice"
                            @click="dismiss_hook_failure(failure[0], failure[1].time)"
                            data-testid="hook-failure-dismiss"
                            class="p-button-rounded p-button-text"/>
                </div>
            </div>
        </div>

</template>
