

let routes= [];
let routes_list= [];

import LayoutPublic from '../layouts/Public.vue'
import Signin from '../pages/public/Signin.vue'
import Signup from '../pages/public/Signup.vue'
import SetupIndex from '../pages/public/setup/Index.vue'
import SetupInstall from '../pages/public/setup/intall/Index.vue'
import Configuration from "../pages/public/setup/intall/Configuration.vue";
import Dependencies from "../pages/public/setup/intall/Dependencies.vue";
import Migrate from "../pages/public/setup/intall/Migrate.vue";
import Account from "../pages/public/setup/intall/Account.vue";
import ForgotPassword from "../pages/public/ForgotPassword.vue";
import ResetPassword from "../pages/public/ResetPassword.vue";




routes_list = [
    {
        path: '/',
        component: LayoutPublic,
        props: true,
        children: [
            {
                path: '/',
                name: 'sign.in',
                component: Signin,
                props: true,
            },
            {
                path: '/forgot-password',
                name: 'forgot.password',
                component: ForgotPassword,
                props: true,
            },
            {
                path: '/signup',
                name: 'signup',
                component: Signup,
                props: true,
            },
            {
                path: '/reset-password/:code?',
                name: 'reset.password_without_code',
                component: ResetPassword,
                props: true,
            },
            {
                path: '/setup',
                name: 'setup.index',
                component: SetupIndex,
                props: true,
            },
            {
                path: '/setup/install',
                name: 'setup.install',
                component: SetupInstall,
                props: true,
                children: [
                    {
                        path: 'configuration',
                        name:'setup.install.configuration',
                        component: Configuration
                    },
                    {
                        path:'migrate',
                        name:'setup.install.migrate',
                        component: Migrate
                    },
                    {
                        path:'dependencies',
                        name:'setup.install.dependencies',
                        component:Dependencies
                    },
                    {
                        path:'account',
                        name:'setup.install.account',
                        component: Account
                    }
                ]
            },
        ]
    }
];

routes.push(...routes_list);

export default routes;

