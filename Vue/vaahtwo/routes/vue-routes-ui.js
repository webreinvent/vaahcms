import UiElements from "../pages/ui/UiElements.vue";


let routes= [];
let routes_list= [];

import Index from '../pages/ui/Index.vue'
import Signin from '../pages/ui/Signin.vue'
import SignUp from "../pages/ui/SignUp.vue";
import Settings from "../pages/ui/Settings.vue";
import GeneralSettings from "../components/organisms/GeneralSettings.vue";
import UserSettings from "../components/organisms/UserSettings.vue";
import NotificationSettings from "../components/organisms/NotificationSettings.vue";
import LocalizationSettings from "../components/organisms/LocalizationSettings.vue";
import EnvVariableSettings from "../components/organisms/EnvVariableSettings.vue";
import UpdateSettings from "../components/organisms/UpdateSettings.vue";
import Install from "../pages/ui/Install.vue";
import Configuration from "../components/organisms/Configuration.vue";
import Dependencies from "../components/organisms/Dependencies.vue";
import Migrate from "../components/organisms/Migrate.vue";
import Account from "../components/organisms/Account.vue";
import ForgotPassword from "../pages/ui/ForgotPassword.vue";
import Setup from "../pages/ui/Setup.vue";
import PublicPages from "../pages/ui/PublicPages.vue";
import PrivatePages from "../pages/ui/PrivatePages.vue";
import Users from "../pages/ui/Users.vue";
import Extend from "../pages/ui/Extend.vue";
import Taxonomies from "../pages/ui/Taxonomies.vue";
import Dashboard from "../pages/ui/Dashboard.vue";
import Media from "../pages/ui/Media.vue";
import MultiFactorAuth from "../pages/ui/MultiFactorAuth.vue";
import Pages from "../pages/ui/Pages.vue";
import MenuContent from "../pages/ui/MenuContent.vue";
import Profile from "../pages/ui/Profile.vue";
import ContentTypes from "../pages/ui/ContentTypes.vue";


routes_list = [{
    path: '/ui',
    name: 'ui.index',
    component: Index,
    props: true,
    children:[
        {
            path:"",
            name:Pages,
            component: Pages
        },
        {
            path: 'public',
            component: PublicPages,
            name: PublicPages,
            children: [
                {
                    path: 'ui-elements',
                    name: 'UiElements',
                    component: UiElements,
                    props: true,
                },
                {
                    path: 'signin',
                    name: 'Signin',
                    component: Signin,
                    props: true,
                },
                {
                    path: 'multi-factor-auth',
                    name: MultiFactorAuth,
                    component: MultiFactorAuth,
                    props: true
                },
                {
                    path: 'signup',
                    name: 'Signup',
                    component: SignUp,
                    props: true
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
            path: 'private',
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
                },
                {
                    path: 'taxonomies',
                    name: Taxonomies,
                    component: Taxonomies
                },
                {
                    path:'dashboard',
                    name: Dashboard,
                    component: Dashboard,
                },
                {
                    path: 'media',
                    name:Media,
                    component: Media
                },
                {
                    name:'ContentTypes',
                    path: 'content',
                    component: ContentTypes
                },
                {
                    path: 'menu',
                    name: MenuContent,
                    component: MenuContent
                },
                {
                    path: 'profile',
                    name: Profile,
                    component: Profile
                }
            ]
        }
    ]
}
]


routes.push(...routes_list);

export default routes;

