import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


import root from './modules/root';
import registrations from './modules/registrations';
import permission from './modules/permission';

export const store = new Vuex.Store({
    modules: {
        root: root,
        registrations: registrations,
        permission: permission,
    }
});
