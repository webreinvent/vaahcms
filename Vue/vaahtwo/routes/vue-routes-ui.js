


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
import Install from "../pages/ui/Install.vue";
import Configuration from "../components/partials/Configuration.vue";
import Dependencies from "../components/partials/Dependencies.vue";
import Migrate from "../components/partials/Migrate.vue";
import Account from "../components/partials/Account.vue";
import ForgotPassword from "../pages/ui/ForgotPassword.vue";
import Setup from "../pages/ui/Setup.vue";
import PublicPages from "../pages/ui/PublicPages.vue";
import PrivatePages from "../pages/ui/PrivatePages.vue";
import Users from "../pages/ui/Users.vue";
import Extend from "../pages/ui/Extend.vue";

routes_list = [{
    path: '/ui',
    name: 'ui.index',
    component: Index,
    props: true,
},
    {
        path: '/public',
        component: PublicPages,
        name: PublicPages,
        children: [
            {
                path: 'signin',
                name: 'Signin',
                component: Signin,
                props: true,
            },
            {
                path: 'forgot-password',
                name: ForgotPassword,
                component: ForgotPassword,
                props: true
            },
            {
                path:'install',
                name: Install,
                component: Install,
                children: [
                    {
                        path: 'configuration',
                        name:Configuration,
                        component: Configuration
                    },
                    {
                        path:'migrate',
                        name:Migrate,
                        component: Migrate
                    },
                    {
                        path:'dependencies',
                        name:Dependencies,
                        component:Dependencies
                    },
                    {
                        path:'account',
                        name:Account,
                        component: Account
                    }
                ]
            },
            {
                path: 'setup',
                name: Setup,
                component: Setup
            },
        ]
    },
    {
        path: '/private',
        name:PrivatePages,
        component: PrivatePages,
        children: [
            {
                path: 'settings',
                name: 'Settings',
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
            {
                path:'users',
                name: Users,
                component: Users
            },
            {
                path: 'extend',
                name:Extend,
                component: Extend
            }
        ]
    }];

routes.push(...routes_list);

export default routes;

