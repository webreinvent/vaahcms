<script  setup>
import { useThemeStore } from '../../../stores/store-themes';
import VhFieldVertical from '../../../vaahvue/vue-three/primeflex/VhFieldVertical.vue';
import {useRootStore} from "../../../stores/root";
const root = useRootStore();
const store = useThemeStore();

</script>

<template>
    <div>

        <Sidebar v-model:visible="store.show_filters" position="right" style="z-index:1000;">
            <VhFieldVertical >
                <template #label>
                    <b>{{root.assets.language_strings.crud_actions.filter_is_active}}:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="active-all"
                                 value="null"
                                 data-testid="themes-filters-active-all"
                                 v-model="store.query.status" />
                    <label for="active-all">{{root.assets.language_strings.crud_actions.filter_is_active_all}}</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="active-all"
                                 value="active"
                                 data-testid="themes-filters-active-all"
                                 v-model="store.query.status" />
                    <label for="active-all">{{store.assets.language_strings.themes_filter_active}}</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="active-true"
                                 data-testid="themes-filters-active-true"
                                 value="inactive"
                                 v-model="store.query.status" />
                    <label for="active-true">{{store.assets.language_strings.themes_filter_inactive}}</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="active-false"
                                 data-testid="themes-filters-active-false"
                                 value="update_available"
                                 v-model="store.query.status" />
                    <label for="active-false">{{store.assets.language_strings.themes_filter_update_available}}</label>
                </div>

            </VhFieldVertical>

        </Sidebar>

    </div>
</template>
