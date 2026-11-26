<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import { useRoute } from "vue-router";
import { useRootStore } from "../../stores/root";

const root = useRootStore();
const route = useRoute();

onMounted(async () => {
    root.verifyInstallStatus();
    await root.getAssets();
});

const expandNode = (item) => {
    root.assets.extended_views.sidebar_menu.success.vaahcms.filter((i) => {
        if(i.index === item.index && i.key === false){
            i.key = true;
            document.getElementById('p-panelmenu-content' + item.index).style.display = 'none';
            document.getElementById('arrow-icon' + item.index).classList.remove('pi-chevron-down');
            document.getElementById('arrow-icon' + item.index).classList.add('pi-chevron-right');
        }
        else if(i.id === item.index && i.key === true){
            i.key = false;
            document.getElementById('p-panelmenu-content' + item.index).style.display = 'initial';
            document.getElementById('arrow-icon' + item.index).classList.remove('pi-chevron-right')
            document.getElementById('arrow-icon' + item.index).classList.add('pi-chevron-down')
        }
    });
}

/* UT-16 (M6-T4a) — the menu data mixes two icon formats: bare names
   ("compass", "user", "pi-box") and one *full* class string ("pi pi-box",
   from ExtendController). The template used to compose `'pi pi-'+item.icon`,
   which produced the malformed `pi pi-pi pi-box` and rendered a broken
   glyph. Normalise the name before composing the class so every icon
   resolves to a real PrimeIcons glyph. */
const iconClass = (icon) => {
    if (!icon) {
        return '';
    }
    let name = String(icon).trim();
    name = name.replace(/^pi\s+/i, '');
    name = name.replace(/^pi-/i, '');
    return name ? 'pi pi-' + name : '';
};

/* UT-15d (M6-T4a) — mark the row of the page the user is on. The menu
   links are absolute URLs carrying the hash route
   ("…/backend#/vaah/users/"), while vue-router exposes the parsed path
   ("/vaah/users/"). Compare the hash part, normalised (no trailing slash,
   lower case). */
const normalisePath = (value) => {
    if (!value) {
        return '';
    }
    let path = String(value);
    if (path.indexOf('#') !== -1) {
        path = path.split('#')[1] || '';
    }
    return path.replace(/\/+$/, '').toLowerCase();
};

const currentPath = computed(() => normalisePath(route.path));

const isActive = (item) => {
    if (!item || !item.link || (item.items && item.items.length)) {
        return false;
    }
    return normalisePath(item.link) === currentPath.value;
};

/* UT-15d follow-up — mark the *section* that contains the current page so only
   it reads as "active". This is independent of which sections happen to be
   expanded: a section the user opened earlier must not stay "lit up" after
   navigating to a different section (expandedKeys never auto-collapse). */
const isInSubtree = (item) => {
    if (!item) {
        return false;
    }
    if (item.link && normalisePath(item.link) === currentPath.value) {
        return true;
    }
    if (item.items && item.items.length) {
        return item.items.some((child) => isInSubtree(child));
    }
    return false;
};

const isCurrentSection = (item) => {
    return !!(item && item.items && item.items.length && isInSubtree(item));
};

</script>

<template>

    <div class="sidebar"
         v-if="root && root.assets && root.assets.extended_views
          && root.assets.extended_views.sidebar_menu"
    >
        <div v-for="menus in root.assets.extended_views.sidebar_menu.success">
            <PanelMenu :model="menus" v-model:expandedKeys="root.sidebar_expanded_keys">
                <template #item="{item}">

                    <div class="p-panelmenu-header-content">
                        <a v-if="!item.items" :href="item.link ?? ''"
                           class="p-panelmenu-header-action p-menuitem-link"
                           :class="{'p-sidebar-item-active': isActive(item)}"
                           :aria-current="isActive(item) ? 'page' : undefined"
                           :data-testid="item ? 'sidebar-' + (item.label ?? '') : ''"
                           tabindex="-1">

                            <span v-if="item.icon" class="p-menuitem-icon" :class="iconClass(item.icon)">

                            </span>
                            <span v-if="item.label" class="p-menuitem-text">{{item.label}}</span>
                        </a>
                        <a v-else
                           class="p-panelmenu-header-action p-menuitem-link"
                           :class="{'p-sidebar-section-active': isCurrentSection(item)}"
                           :data-testid="item ? 'sidebar-' + (item.label ?? '') : ''"
                           tabindex="-1">

                            <span v-if="item.icon" class="p-menuitem-icon" :class="iconClass(item.icon)">

                            </span>
                            <span v-if="item.label" class="p-menuitem-text">{{item.label}}</span>
                            <span v-if="item.items" class="p-submenu-icon pi pi-chevron-right">

                            </span>
                        </a>
                    </div>

                </template>
            </PanelMenu>
        </div>
    </div>
</template>
