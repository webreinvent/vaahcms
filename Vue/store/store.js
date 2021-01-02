import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import root from './modules/root';
import registrations from './modules/registrations';
import setup from './modules/setup';
import users from './modules/users';
import permissions from './modules/permissions';
import roles from './modules/roles';
import modules from './modules/modules';
import themes from './modules/themes';
import profile from './modules/profile';
import general from './modules/settings/general';
import localizations from './modules/settings/localizations';
import notifications from './modules/settings/notifications';
import media from './modules/media';
import logs from './modules/advanced/logs';
import jobs from './modules/store-jobs';
import failed_jobs from './modules/advanced/failed-jobs';
import batches from './modules/store-job-batches';

export const store = new Vuex.Store({
    modules: {
        root: root,
        registrations: registrations,
        setup: setup,
        permissions: permissions,
        roles: roles,
        users: users,
        modules: modules,
        themes: themes,
        profile: profile,
        general: general,
        localizations: localizations,
        notifications: notifications,
        media: media,
        logs: logs,
        jobs: jobs,
        failed_jobs: failed_jobs,
        batches: batches,
    }
});
