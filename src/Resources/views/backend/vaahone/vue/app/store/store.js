import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


import root from './modules/root';
import registrations from './modules/registrations';
import setup from './modules/setup';
import permission from './modules/permission';

export const store = new Vuex.Store({
    modules: {
        root: root,
        registrations: registrations,
        setup: setup,
        permission: permission,
    }
});
