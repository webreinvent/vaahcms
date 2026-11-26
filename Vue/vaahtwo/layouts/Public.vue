<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A layout declares
// none of them, so Vue's attribute inheritance drops the param on the
// layout's root element - as id="1", id="5", ... - and the same param
// reaches the family layout and the page, so one screen carried the same
// id three or four times. A layout takes nothing from the router, so it
// opts out of the inheritance; the page keeps its own (unique) id.
defineOptions({ inheritAttrs: false });
import {onMounted} from "vue";

import { useRootStore } from '../stores/root'
import ThemeToggle from '../components/molecules/ThemeToggle.vue'
import { applyPreference } from '../vaahvue/theme/dark-mode'
const rootStore = useRootStore();


onMounted(async () => {
    await rootStore.getAssets();
});

// M6-T4a (F23) — pre-auth light/dark switch (DESIGN-SYSTEM.md §9). This layout
// wraps the setup wizard + the sign-in / signup / reset screens — none of
// which have a user to persist to yet, so the switch applies the scheme
// locally (the `app-dark` class on <html>) and caches it for reload
// continuity via the pre-paint script. The per-user preference is set through
// the topnav toggle (rootStore.setDarkMode) once signed in.
function applyLocalMode(mode) {
    applyPreference(mode);
}

</script>


<template>

    <div class="public-pages">
        <div class="public-theme-toggle">
            <ThemeToggle testId="Public-DarkModeToggle" @toggle="applyLocalMode" />
        </div>
        <div class="grid">
            <!-- UT-56 — `col-8` is a *desktop* width: on a 375px viewport it
                 left the wizard inside a 223px column, so the stepper, the
                 env chip and every form field were squeezed to a third of
                 the screen. The column is full width below the `md`
                 breakpoint and 8/12 from `md` up. -->
            <div class="col-12 md:col-8 mt-6 mx-auto">
                <div class="col"><RouterView /></div>
            </div>
        </div>
    </div>

</template>
