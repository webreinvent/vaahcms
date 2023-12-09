
import {createApp, markRaw} from 'vue';
import { createPinia, PiniaVuePlugin  } from 'pinia'


//-------------PrimeVue Imports

import PrimeVue from "primevue/config";
import Avatar from 'primevue/avatar';
import BadgeDirective from "primevue/badgedirective";
import Button from 'primevue/button';
import ConfirmDialog from 'primevue/confirmdialog';
import ConfirmationService from 'primevue/confirmationservice';
import DialogService from 'primevue/dialogservice'
import InputText from 'primevue/inputtext';
import Menu from 'primevue/menu';
import Menubar from 'primevue/menubar';
import PanelMenu from 'primevue/panelmenu';
import ProgressBar from 'primevue/progressbar';
import Ripple from 'primevue/ripple';
import StyleClass from 'primevue/styleclass';
import TieredMenu from 'primevue/tieredmenu';
import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';
import Tooltip from 'primevue/tooltip';
//-------------/PrimeVue Imports


//-------------APP
import App from "./layouts/AppExtended.vue"

const app = createApp(App);

const pinia = createPinia();
app.use(pinia);
app.use(PiniaVuePlugin);

//-------------/APP


//-------------PrimeVue Use
app.use(PrimeVue, { ripple: true });
app.use(ConfirmationService);
app.use(ToastService);
app.use(DialogService);


app.directive('tooltip', Tooltip);
app.directive('badge', BadgeDirective);
app.directive('ripple', Ripple);
app.directive('styleclass', StyleClass);

app.component('ConfirmDialog', ConfirmDialog);
app.component('Menu', Menu);
app.component('ProgressBar', ProgressBar);
app.component('Toast', Toast);
app.component('Menubar', Menubar);
app.component('Avatar', Avatar);
app.component('Button', Button);
app.component('InputText', InputText);
app.component('TieredMenu', TieredMenu);
app.component('PanelMenu', PanelMenu);
//-------------/PrimeVue Use


app.mount('#themeVaahTwoExtend')


export { app }
