import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


import root from './modules/root';

export const store = new Vuex.Store({
    modules: {
        root: root,
    }
});
