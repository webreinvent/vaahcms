import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


import root from './modules/root';
import registrations from './modules/registrations';
import setup from './modules/setup';
import users from './modules/users';
import permissions from './modules/permissions';
import roles from './modules/roles';

export const store = new Vuex.Store({
    modules: {
        root: root,
        registrations: registrations,
        setup: setup,
        permissions: permissions,
        roles: roles,
        users: users,
    }
});
