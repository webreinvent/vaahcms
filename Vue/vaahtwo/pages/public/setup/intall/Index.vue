<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });

import {onMounted, reactive, computed, nextTick, watch} from "vue";
import {useRoute, useRouter} from 'vue-router';

import { useSetupStore } from '../../../../stores/setup'
const store = useSetupStore();
import { useRootStore } from '../../../../stores/root'
import Footer from "../../../../components/organisms/Footer.vue"

const root = useRootStore();
const route = useRoute();
const router = useRouter();

//OpenVue v4 Stepper is value-driven (v-model:value) — v3's uncontrolled
//render never marked the active step. The value is derived from the
//current route (one install sub-route per step); setting it navigates,
//so a clicked step header moves the wizard.
//
// UT-52 — the step values are **1-based**: the stepper prints the step's
//own value in the number circle, so a 0-based value rendered "0" in the
//circle next to a "1. Configuration" label. The model and the items now
//share the same 1-based space.
const active_step = computed({
    get: () => {
        let index = store.install_items.findIndex(item => item.to === route.path);
        return index > -1 ? index + 1 : 1;
    },
    set: (value) => {
        let item = store.install_items[value - 1];
        if(item && item.to !== route.path)
        {
            router.push(item.to);
        }
    }
});

// UT-53 — on a narrow viewport the four wizard steps do not fit, so the
// stepper scrolls horizontally. The active step must be visible without
// the user having to guess which way to scroll.
//
// `Element.scrollIntoView` did not do it here: the scroll container is the
// engine's `.p-steplist`, and the call resolved before the engine had
// measured the step widths, so nothing moved. The offset is computed and
// assigned to the scroller directly instead.
//
// The stepper renders asynchronously (the engine applies the `active` class
// once it has measured), so a single tick is not enough — the attempt is
// repeated over a few frames until the active step is actually found.
const scroll_active_step_into_view = (attempt = 0) => {
    nextTick(() => {
        let list = document.querySelector('.vh-step .p-steplist');
        let active = document.querySelector('.vh-step .p-stepitem-active');
        if (!list || !active) {
            if (attempt < 12) requestAnimationFrame(() => scroll_active_step_into_view(attempt + 1));
            return;
        }
        let target = active.offsetLeft - (list.clientWidth - active.offsetWidth) / 2;
        let max = list.scrollWidth - list.clientWidth;
        list.scrollLeft = Math.max(0, Math.min(target, max));
    });
};

onMounted(async () => {
    await store.getAssets();
    await store.getStatus();
    scroll_active_step_into_view();
});

// The step is derived from the route, but `store.install_items` is filled
// asynchronously — on a direct load the stepper first renders step 1 and
// only later the real step. Watching the derived value (not the route)
// covers both the navigation and the late-arriving list.
watch(active_step, () => scroll_active_step_into_view());
</script>

<template>
    <div v-if="store && store.assets && root && root.assets" class="">
        <div class="text-center mb-4">
            <img v-if="root.assets.backend_logo_url"
                 :src="root.assets.backend_logo_url" alt=""
                 class="mb-2 mx-auto h-3rem">
            <!-- UT-129 (UAT sweep) — the wizard step title is the screen's
                 top-level heading, so it is an <h1>; `vc-text-20` pins the
                 size and weight, so the rendering is unchanged. -->
            <h1 class="vc-text-20 font-semibold">Install VaahCMS</h1>
        </div>
        <div class="container vh-step relative">
            <Stepper
                v-model:value="active_step"
                class="my-4"
            >
                <StepList>
                    <StepItem v-for="(item, index) in store.install_items" :value="index + 1" :key="index">
                        <Step :value="index + 1">
                            <!-- UT-85 — the step title was a router-link nested
                                 inside the engine's step header button: one
                                 interactive control inside another, and the
                                 link duplicated what the header already does
                                 (clicking the header drives `active_step`,
                                 which navigates to the step's route — verified
                                 live). The title is now plain content; the
                                 header button is the single control. -->
                            <span class="flex align-items-center font-medium">
                                    <i :class="item.icon" class="step-icon"></i>
                                    <span class="step-label">&nbsp;{{item.label}}</span>
                            </span>
                        </Step>
                    </StepItem>
                </StepList>
            </Stepper>
            <!-- UT-51 — the env chip used to be absolutely positioned, so it
                 floated over the footer / the card's top edge. It is a status
                 chip: it now sits on its own centred line. -->
            <div v-if="store.assets.env_file" class="flex justify-content-center my-2">
                <Tag class="vh-env-tag bg-black-alpha-70 vc-dense"
                     :pt="{
                  root: {
                           'data-testid': `setup-use_env`
                        }
              }">
                    <span class="font-medium">ACTIVE ENV FILE: </span>
                    <b class="ml-1">{{ store.assets.env_file }}</b>
                </Tag>
            </div>
            <router-view />

            <Footer class="mt-3"/>
        </div>
    </div>
</template>

