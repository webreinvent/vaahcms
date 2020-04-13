import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


import root from './modules/root';
import registrations from './modules/registrations';
import users from './modules/users';
import permissions from './modules/permissions';
import roles from './modules/roles';
import setup from './modules/setup';
import permission from './modules/permission';
import users from './modules/users';
import permissions from './modules/permissions';
import roles from './modules/roles';

export const store = new Vuex.Store({
    modules: {
        root: root,
        registrations: registrations,
        permissions: permissions,
        roles: roles,
        users: users,
        setup: setup,
        permission: permission,
        permissions: permissions,
        roles: roles,
        users: users,
    }
});
