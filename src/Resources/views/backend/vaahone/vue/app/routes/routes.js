let routes;
let routes_list=[];


routes= [
    { path: '*', redirect: '/' }
];



//----------Middleware
import GetAssets from './middleware/GetAssets'
import IfNotSetup from './middleware/IfNotSetup'
import GetSetupStatus from './middleware/GetSetupStatus'
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
        }

    ]
};

routes.push(routes_frontend);

/*
|--------------------------------------------------------------------------
| Setup Routes
|--------------------------------------------------------------------------
*/

import SetupIndex from "./../pages/setup/Index";
import InstallIndex from "./../pages/setup/install/Index";
import InstallConfiguration from "./../pages/setup/install/Configuration";
import InstallMigrate from "./../pages/setup/install/Migrate";
import InstallDependencies from "./../pages/setup/install/Dependencies";
import InstallAccount from "./../pages/setup/install/Account";


routes_list =     {
    path: '/setup',
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
            name: 'setup.index',
            component: SetupIndex,
            props: true,
            meta: {
                middleware: [
                    GetAssets
                ]
            },
        },
        {
            path: 'install',
            name: 'setup.install',
            component: InstallIndex,
            props: true,
            meta: {
                middleware: [
                    GetAssets,
                    GetSetupStatus,
                ]
            },
            children: [
                {
                    path: '/',
                    name: 'setup.install.configuration',
                    component: InstallConfiguration,
                    props: true,
                    meta: {
                        middleware: [
                            GetAssets,
                            GetSetupStatus,
                        ]
                    },
                },
                {
                    path: 'migrate',
                    name: 'setup.install.migrate',
                    component: InstallMigrate,
                    props: true,
                    meta: {
                        middleware: [
                            GetAssets,
                            GetSetupStatus,
                        ]
                    },
                },
                {
                    path: 'dependencies',
                    name: 'setup.install.dependencies',
                    component: InstallDependencies,
                    props: true,
                    meta: {
                        middleware: [
                            GetAssets,
                            GetSetupStatus,
                        ]
                    },
                },
                {
                    path: 'account',
                    name: 'setup.install.account',
                    component: InstallAccount,
                    props: true,
                    meta: {
                        middleware: [
                            GetAssets,
                            GetSetupStatus,
                        ]
                    },
                },
            ]
        },


    ]
};

routes.push(routes_list);


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



import PermList from "./../pages/permissions/List";
import PermView from "./../pages/permissions/View";
import PermRole from "./../pages/permissions/ViewRole";
import PermEdit from "./../pages/permissions/Edit";

let routes_perm =     {
    path: '/vaah/permissions',
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




import RoleList from "./../pages/roles/List";
import RoleCreate from "../pages/roles/Create.vue";
import RoleView from "./../pages/roles/View";
import RoleViewPermission from "./../pages/roles/ViewPermission";
import RoleViewUser from "./../pages/roles/ViewUser";
import RoleEdit from "./../pages/roles/Edit";

let routes_roles =     {
    path: '/vaah/roles',
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
            name: 'role.list',
            component: RoleList,
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
                    name: 'role.create',
                    component: RoleCreate,
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
                    name: 'role.view',
                    component: RoleView,
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
                    name: 'role.edit',
                    component: RoleEdit,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    },
                },
                {
                    path: 'permission/:id',
                    name: 'role.perm',
                    component: RoleViewPermission,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    },
                },
                {
                    path: 'user/:id',
                    name: 'role.user',
                    component: RoleViewUser,
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

routes.push(routes_roles);


export default routes;
