<script  setup>
import { useThemeStore } from '../../../stores/store-themes';
import VhFieldVertical from '../../../vaahvue/vue-three/primeflex/VhFieldVertical.vue';

const store = useThemeStore();

</script>

<template>
    <div>

        <Sidebar v-model:visible="store.show_filters" position="right" style="z-index:1000;">
            <VhFieldVertical >
                <template #label>
                    <b>Is Active:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="active-all"
                                 value="null"
                                 data-testid="themes-filters-active-all"
                                 v-model="store.query.status" />
                    <label for="active-all">All</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="active-all"
                                 value="active"
                                 data-testid="themes-filters-active-all"
                                 v-model="store.query.status" />
                    <label for="active-all">Active</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="active-true"
                                 data-testid="themes-filters-active-true"
                                 value="inactive"
                                 v-model="store.query.status" />
                    <label for="active-true">InActive</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="active-false"
                                 data-testid="themes-filters-active-false"
                                 value="update_available"
                                 v-model="store.query.status" />
                    <label for="active-false">Updates Available</label>
                </div>

            </VhFieldVertical>

        </Sidebar>

    </div>
</template>
