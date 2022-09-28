let routes;
let routes_list=[];


routes= [
    { path: '*', redirect: '/' }
];



//----------Middleware
import GetAssets from './middleware/GetAssets'
import ResetRootAssets from './middleware/ResetRootAssets'
import GetSetupStatus from './middleware/GetSetupStatus'
import SetAssetsToReload from './middleware/SetAssetsToReload'
import IfNotSetup from './middleware/IfNotSetup'
import IsLoggedIn from './middleware/IsLoggedIn'
import GetBackendAssets from './middleware/GetBackendAssets'
//----------Middleware




/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
import LayoutPublic from "./../layouts/Public.vue";


import SignIn from "./../pages/SignIn.vue";
import ForgotPassword from "./../pages/ForgotPassword.vue";
import ResetPassword from "./../pages/ResetPassword";

let routes_frontend =     {
    path: '/',
    component: LayoutPublic,
    props: true,
    meta: {
        middleware: [
            GetAssets,
            IfNotSetup,
        ]
    },
    children: [
        {
            path: '/',
            name: 'sign.in',
            component: SignIn,
            props: true,
            meta: {
                middleware: [
                    GetAssets,
                    SetAssetsToReload,
                    IfNotSetup,
                ]
            },
        },
        {
            path: '/forgot-password',
            name: 'forgot.password',
            component: ForgotPassword,
            props: true,
            meta: {
                middleware: [
                    GetAssets,
                    IfNotSetup,
                ]
            },
        },
        {
            path: '/reset-password/:code',
            name: 'reset.password_with_code',
            component: ResetPassword,
            meta: {
                middleware: [
                    GetAssets,
                    IfNotSetup,
                ]
            },
        },
        {
            path: '/reset-password',
            name: 'reset.password_without_code',
            component: ResetPassword,
            meta: {
                middleware: [
                    GetAssets,
                    IfNotSetup,
                ]
            },
        }

    ]
};

routes.push(routes_frontend);



/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
*/
import LayoutBackend from "./../layouts/Backend.vue";
import Index from "./../pages/dashboard/Index.vue";

let routes_backend =     {
    path: '/vaah',
    component: LayoutBackend,
    props: true,
    meta: {
        middleware: [
            IsLoggedIn,
            GetBackendAssets
        ]
    },
    children: [
        {
            path: '/',
            name: 'dashboard.index',
            component: Index,
            props: true,
            meta: {
                middleware: [
                    IsLoggedIn,
                    GetBackendAssets
                ]
            },
        }

    ]
};

routes.push(routes_backend);


import Profile from "./../pages/profile/Index.vue";


let routes_profile =     {
    path: '/vaah/',
    component: LayoutBackend,
    props: true,
    meta: {
        middleware: [
            IsLoggedIn,
            GetBackendAssets
        ]
    },
    children: [
        {
            path: 'profile',
            component: Profile,
            props: true,
            meta: {
                middleware: [
                    IsLoggedIn,
                    GetBackendAssets
                ]
            },
        }

    ]
};

routes.push(routes_profile);

import manage from "./routes-manage";
import modules from "./routes-modules";
import permissions from "./routes-permissions";
import registrations from "./routes-registrations";
import roles from "./routes-roles";
import settings from "./routes-settings";
import setup from "./routes-setup";
import themes from "./routes-themes";
import users from "./routes-users";
import advanced from "./routes-advanced";


routes = routes.concat(
    routes, manage, modules, permissions, registrations,
    roles, settings, setup, themes, users, advanced,

);

export default routes;
