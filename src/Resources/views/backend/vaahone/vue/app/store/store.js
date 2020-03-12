import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


import root from './modules/root';
import registrations from './modules/registrations';

export const store = new Vuex.Store({
    modules: {
        root: root,
        registrations: registrations,
    }
});
