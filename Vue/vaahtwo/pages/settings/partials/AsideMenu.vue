<script setup>
/* M6-T4 (F23) — migrated from the v3 BootstrapVue menu tree.
   The v3 markup (`<b-menu class="is-light">` / `<b-menu-list>` /
   `<b-menu-item>`) resolved to no component in the OpenVue registry — the
   `b-*` tags rendered as unknown elements and `is-light` was a v3 BEM
   modifier. The v4 `Menu` is a *popup* component with no inline-list
   equivalent, so the aside navigation is plain, semantic markup instead:
   the same routes, the same labels and the same active state (router-link
   owns the active class, so the state cannot drift from the route). */
import { useRoute } from 'vue-router';

const route = useRoute();

const items = [
    { label: 'General', icon: 'pi pi-cog', name: 'general.index', path: '/vaah/settings/general' },
    { label: 'User Settings', icon: 'pi pi-users', name: 'user-setting.index', path: '/vaah/settings/user-settings' },
    { label: 'Env Variables', icon: 'pi pi-code', name: 'env.index', path: '/vaah/settings/env-variables' },
    { label: 'Localizations', icon: 'pi pi-language', name: 'localization.index', path: '/vaah/settings/localization' },
    { label: 'Notifications', icon: 'pi pi-bell', name: 'notifications.index', path: '/vaah/settings/notifications' },
    { label: 'Update', icon: 'pi pi-download', name: 'update.index', path: '/vaah/settings/update' },
    { label: 'Reset', icon: 'pi pi-refresh', name: 'setup.index', path: null },
];
</script>

<template>

    <nav class="vaah-settings-menu">
        <ul class="list-none p-0 m-0">
            <li v-for="item in items" :key="item.name">
                <router-link :to="{ name: item.name }"
                             :class="{ 'vaah-settings-menu-active': item.path && route.path === item.path }"
                             class="vaah-settings-menu-link">
                    <i :class="item.icon" aria-hidden="true"></i>
                    <span>{{ item.label }}</span>
                </router-link>
            </li>

            <!--<li>
                <router-link :to="{ name: 'general.index' }" class="vaah-settings-menu-link">
                    <i class="pi pi-stopwatch" aria-hidden="true"></i>
                    <span>Scheduled Actions</span>
                </router-link>
            </li>
            <li>
                <router-link :to="{ name: 'backups.index' }" class="vaah-settings-menu-link">
                    <i class="pi pi-hdd" aria-hidden="true"></i>
                    <span>Backups</span>
                </router-link>
            </li>-->
        </ul>
    </nav>

</template>

<style scoped>

.vaah-settings-menu-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: 6px;
    color: var(--p-text-color);
    text-decoration: none;
}

.vaah-settings-menu-link:hover {
    background: var(--p-content-hover-background);
}

.vaah-settings-menu-active {
    background: var(--p-highlight-background);
    font-weight: 600;
}

</style>
