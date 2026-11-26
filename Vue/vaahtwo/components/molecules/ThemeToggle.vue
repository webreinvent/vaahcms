<script setup>
// M6-T4a (F23) — shared light/dark toggle (DESIGN-SYSTEM.md §9). The single
// source of the "resolved scheme → moon/sun" affordance, used by the
// authenticated topnav (persist via rootStore.setDarkMode) and the pre-auth
// Public layout (apply locally). It reflects the *resolved* scheme — the
// `app-dark` class on <html> — via a MutationObserver, so the icon is correct
// under the pre-paint script, the OS 'system' watcher, and the store. It only
// DISPLAYS and EMITS: the parent decides whether to persist (auth) or apply
// locally (pre-auth surfaces — no user to persist to).
import {onBeforeUnmount, onMounted, ref} from "vue";

const emit = defineEmits(['toggle']);
const props = defineProps({
    // data-testid on the button (context-specific, e.g. "Topnav-DarkModeToggle")
    testId: {type: String, default: 'DarkModeToggle'},
});

const isDark = ref(typeof document !== 'undefined'
    && document.documentElement.classList.contains('app-dark'));

let observer = null;

function syncDarkMode() {
    isDark.value = document.documentElement.classList.contains('app-dark');
}

onMounted(() => {
    syncDarkMode();
    observer = new MutationObserver(syncDarkMode);
    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class'],
    });
});

onBeforeUnmount(() => {
    if (observer) observer.disconnect();
});

// emits the NEW desired mode ('light' when currently dark, and vice-versa)
function onToggle() {
    emit('toggle', isDark.value ? 'light' : 'dark');
}

</script>

<template>
    <Button class="mr-2"
            size="small"
            rounded
            text
            severity="secondary"
            :icon="isDark ? 'pi pi-sun' : 'pi pi-moon'"
            :aria-label="isDark ? 'Switch to light mode' : 'Switch to dark mode'"
            :data-testid="testId"
            @click="onToggle"/>
</template>
