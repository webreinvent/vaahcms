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


import UserList from "./../pages/users/List";
import UserCreate from "./../pages/users/Create";
import UserView from "./../pages/users/View";
import UserRole from "./../pages/users/ViewRole";
import UserEdit from "./../pages/users/Edit";

let routes_user =     {
    path: '/vaah/users',
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
            name: 'user.list',
            component: UserList,
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
                    name: 'user.create',
                    component: UserCreate,
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
                    name: 'user.view',
                    component: UserView,
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
                    name: 'user.role',
                    component: UserRole,
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
                    name: 'user.edit',
                    component: UserEdit,
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

routes.push(routes_user);



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




import ModuleList from "./../pages/modules/List";
import ModuleView from "./../pages/modules/View";
import ModuleInstall from "./../pages/modules/Install";

let routes_modules =     {
    path: '/vaah/modules',
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
            name: 'modules.list',
            component: ModuleList,
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
                    name: 'modules.view',
                    component: ModuleView,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    },
                },
                {
                    path: 'install',
                    name: 'modules.install',
                    component: ModuleInstall,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    },
                },

            ]

        }

    ]
};

routes.push(routes_modules);



import ThemeList from "./../pages/themes/List";
import ThemeView from "./../pages/themes/View";
import ThemeInstall from "./../pages/themes/Install";

let routes_themes =     {
    path: '/vaah/themes',
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
            name: 'themes.list',
            component: ThemeList,
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
                    name: 'themes.view',
                    component: ThemeView,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    },
                },
                {
                    path: 'install',
                    name: 'themes.install',
                    component: ThemeInstall,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    },
                },

            ]

        }

    ]
};

routes.push(routes_themes);


import SettingsLayout from "./../pages/settings/SettingsLayout";
import GeneralIndex from "./../pages/settings/general/Index";
import LocalizationIndex from "./../pages/settings/localization/Index";
import EnvIndex from "./../pages/settings/env/Index";
import BackupsIndex from "./../pages/settings/backups/Index";

let routes_setting_localization =     {
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
            path: 'settings',
            component: SettingsLayout,
            props: true,
            meta: {
                middleware: [
                    IsLoggedIn,
                    GetBackendAssets
                ]
            },
            children: [
                {
                    path: 'general',
                    name: 'general.index',
                    component: GeneralIndex,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    }
                },
                {
                    path: 'env-variables',
                    name: 'env.index',
                    component: EnvIndex,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    }
                },
                {
                    path: 'localization',
                    name: 'localization.index',
                    component: LocalizationIndex,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    }
                },
                {
                    path: 'backups',
                    name: 'backups.index',
                    component: BackupsIndex,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    }
                },

            ]
        }

    ]
};

routes.push(routes_setting_localization);


import Profile from "./../pages/profile/Index";


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




export default routes;
