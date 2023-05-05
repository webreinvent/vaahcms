import SettingsLayout from "../pages/settings/SettingsLayout.vue";

let routes= [];
let routes_list= [];

import LayoutBackend from "../layouts/Backend.vue";
import GeneralIndex from "../pages/settings/general/Index.vue";
import EnvIndex from "../pages/settings/env/Index.vue";
import UserSettingIndex from "../pages/settings/user-settings/Index.vue";
import LocalizationIndex from "../pages/settings/localization/Index.vue";
import NotificationsIndex from "../pages/settings/notifications/Index.vue";
import UpdateIndex from "../pages/settings/update/Index.vue";
// import BackupsIndex from "../pages/settings/backups/Index.vue";


routes_list = {
    path: '/vaah/settings/',
    component: LayoutBackend,
    props: true,
    children: [
        {
            path: '',
            component: SettingsLayout,
            props: true,
            children: [
                {
                    path: 'general',
                    name: 'general.index',
                    component: GeneralIndex,
                    props: true,
                },
                {
                    path: 'env-variables',
                    name: 'env.index',
                    component: EnvIndex,
                    props: true,
                },
                {
                    path: 'user-settings',
                    name: 'user-setting.index',
                    component: UserSettingIndex,
                    props: true,
                },
                {
                    path: 'localization',
                    name: 'localization.index',
                    component: LocalizationIndex,
                    props: true,
                },
                {
                    path: 'notifications',
                    name: 'notifications.index',
                    component: NotificationsIndex,
                    props: true,
                },
                {
                    path: 'update',
                    name: 'update.index',
                    component: UpdateIndex,
                    props: true,
                },
                /*{
                    path: 'backups',
                    name: 'backups.index',
                    component: BackupsIndex,
                    props: true,
                },*/

            ]
        }

    ]
};

routes.push(routes_list);

export default routes;

