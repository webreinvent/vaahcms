
let routes= [];
let routes_list= [];

import Index from '../pages/ui/Index.vue'
import Signin from '../pages/ui/Signin.vue'
import Settings from "../pages/ui/Settings.vue";
import GeneralSettings from "../components/partials/GeneralSettings.vue";
import UserSettings from "../components/partials/UserSettings.vue";
import NotificationSettings from "../components/partials/NotificationSettings.vue";
import LocalizationSettings from "../components/partials/LocalizationSettings.vue";
import EnvVariableSettings from "../components/partials/EnvVariableSettings.vue";
import UpdateSettings from "../components/partials/UpdateSettings.vue";

routes_list = {
    path: '/ui',
    name: 'ui.index',
    component: Index,
    props: true,
    children: [
        {
            path: 'signin',
            name: 'ui.signin',
            component: Signin,
            props: true,
        },
        {
            path: 'settings',
            name: 'ui.settings',
            component: Settings,
            children:[
                {
                    path:'general-settings',
                    name:GeneralSettings,
                    component: GeneralSettings
                },
                {
                    path:'user-settings',
                    name:UserSettings,
                    component: UserSettings
                },
                {
                    path:'env-variables-settings',
                    name:EnvVariableSettings,
                    component: EnvVariableSettings
                },
                {
                    path:'notification-settings',
                    name:NotificationSettings,
                    component: NotificationSettings
                },
                {
                    path:'localization-settings',
                    name:LocalizationSettings,
                    component: LocalizationSettings
                },
                {
                    path:'update-settings',
                    name:UpdateSettings,
                    component: UpdateSettings
                }
            ]
        },
    ]
};

routes.push(routes_list);

export default routes;

