import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


import root from './modules/root';
import registrations from './modules/registrations';
import permissions from './modules/permissions';
import roles from './modules/roles';

export const store = new Vuex.Store({
    modules: {
        root: root,
        registrations: registrations,
        permissions: permissions,
        roles: roles,
    }
});
