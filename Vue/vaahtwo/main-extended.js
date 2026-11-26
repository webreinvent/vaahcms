
import {createApp, markRaw} from 'vue';
import { createPinia } from 'pinia'

// M3-T2 (F10) — the single canonical admin stylesheet (R4.9): build.scss is
// part of the Vite graph (same as main.js) so the extended SPA serves the
// converged build (PrimeFlex v4 + OpenIcons compat + the token-driven app
// layer) from build/index.css.
import '../../Resources/assets/backend/vaahtwo/scss/build.scss';


// M3-T3 (F11) — OpenVue is now the sole component substrate (PrimeVue 3
// registry retired). The OpenVue config plugin registers config + theme
// services only (no global components/directives); component + directive
// resolution happens at build time via @openvue/auto-import-resolver in
// vite.config.js (ADR-004).
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
import App from "./layouts/AppExtended.vue"

const app = createApp(App);

const pinia = createPinia();
app.use(pinia);

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
// M3-T3 (F11): the 10 manual `app.component()` registrations of the
// PrimeVue 3 era are retired (ADR-004); every component used in this
// entry's templates is resolved at build time by
// @openvue/auto-import-resolver (PrimeVueResolver) in vite.config.js.
//-------------/OpenVue Use


app.mount('#themeVaahTwoExtend')


export { app }
