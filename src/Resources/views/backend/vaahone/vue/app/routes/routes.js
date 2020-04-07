let routes;
let routes_list=[];


routes= [
    { path: '*', redirect: '/' }
];



//----------Middleware
import GetAssets from './middleware/GetAssets'
import IsLoggedIn from './middleware/IsLoggedIn'
import GetBackendAssets from './middleware/GetBackendAssets'
//----------LayoutApp




/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
import LayoutPublic from "./../layouts/Public";


import SignIn from "./../pages/SignIn";
import ForgotPassword from "./../pages/ForgotPassword";

let routes_frontend =     {
    path: '/',
    component: LayoutPublic,
    props: true,
    meta: {
        middleware: [
            GetAssets
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
                    GetAssets
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
                    GetAssets
                ]
            },
        }

    ]
};

routes.push(routes_frontend);


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
import LayoutBackend from "./../layouts/Backend";
import Index from "./../pages/dashboard/Index";

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


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

import RegList from "./../pages/registrations/List";
import RegCreate from "./../pages/registrations/Create";
import RegView from "./../pages/registrations/View";
import RegEdit from "./../pages/registrations/Edit";

let routes_reg =     {
    path: '/vaah/registrations',
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
            name: 'reg.list',
            component: RegList,
            props: true,
            meta: {
                middleware: [
                    IsLoggedIn,
                    GetBackendAssets
                ]
            },
            children: [
                {
                    path: 'create',
                    name: 'reg.create',
                    component: RegCreate,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    },
                },
                {
                    path: 'view/:id',
                    name: 'reg.view',
                    component: RegView,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    },
                },
                {
                    path: 'edit/:id',
                    name: 'reg.edit',
                    component: RegEdit,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    },
                }

            ]
        }

    ]
};

routes.push(routes_reg);



import PermList from "./../pages/permission/List";
import PermView from "./../pages/permission/View";
import PermRole from "./../pages/permission/ViewRole";
import PermEdit from "./../pages/permission/Edit";

let routes_perm =     {
    path: '/vaah/permission',
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
            name: 'perm.list',
            component: PermList,
            props: true,
            meta: {
                middleware: [
                    IsLoggedIn,
                    GetBackendAssets
                ]
            },
            children: [
                {
                    path: 'view/:id',
                    name: 'perm.view',
                    component: PermView,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    },
                },
                {
                    path: 'role/:id',
                    name: 'perm.role',
                    component: PermRole,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    },
                },
                {
                    path: 'edit/:id',
                    name: 'perm.edit',
                    component: PermEdit,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    },
                }

            ]
        }

    ]
};

routes.push(routes_perm);


export default routes;
