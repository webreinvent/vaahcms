
import {createApp, markRaw} from 'vue';
import { createPinia } from 'pinia'

// M3-T2 (F10) — the single canonical admin stylesheet (R4.9): build.scss is
// now part of the Vite graph, so build/index.css carries the converged
// build (PrimeFlex v4 + OpenIcons compat + the token-driven app layer).
// Laravel Mix is retired for this package.
import '../../Resources/assets/backend/vaahtwo/scss/build.scss';

// M3-T3 (F11) — OpenVue is now the sole component substrate (PrimeVue 3
// registry retired). The OpenVue config plugin registers config + theme
// services only (no global components/directives); component + directive
// resolution happens at build time via @openvue/auto-import-resolver in
// vite.config.js (ADR-004). theme.options is exactly three keys (R4.5):
// prefix / darkModeSelector / cssLayer — see vaahvue/theme/openvue.js.
import OpenVue from 'openvue/config';
import VaahPreset, { THEME_OPTIONS } from './vaahvue/theme/openvue'


//-------------OpenVue services + directives

import ConfirmationService from 'openvue/confirmationservice';
import DialogService from 'openvue/dialogservice';
import ToastService from 'openvue/toastservice';
import Tooltip from 'openvue/tooltip';
import Ripple from 'openvue/ripple';
import StyleClass from 'openvue/styleclass';
import BadgeDirective from 'openvue/badgedirective';
//-------------/OpenVue services + directives


//-------------APP
import App from "./layouts/App.vue"
import router from './routes/router'

const app = createApp(App);

const pinia = createPinia();
pinia.use(({ store }) => {
    store.$router = markRaw(router)
});
app.use(pinia);
app.use(router);
//-------------/APP


//-------------OpenVue Use
// M3-T1 (F09) — OpenVue styled-mode theme (Nide preset, .app-dark dark mode).
app.use(OpenVue, { ripple: true, theme: { preset: VaahPreset, options: THEME_OPTIONS } });
app.use(ConfirmationService);
app.use(ToastService);
app.use(DialogService);

app.directive('tooltip', Tooltip);
app.directive('badge', BadgeDirective);
app.directive('ripple', Ripple);
app.directive('styleclass', StyleClass);
// M3-T3 (F11): the 46 manual `app.component()` registrations of the PrimeVue 3
// era are retired (ADR-004). Every component used in templates — including
// the v4-only sub-components (TabList, Tab, TabPanels, AccordionPanel,
// AccordionHeader, AccordionContent, StepList, Step, StepPanels, StepPanel,
// StepItem, OverlayBadge) — is resolved at build time by
// @openvue/auto-import-resolver (PrimeVueResolver) in vite.config.js. No
// manual registration remains as a fallback.
//-------------/OpenVue Use


app.mount('#themeVaahTwo')


export { app }
