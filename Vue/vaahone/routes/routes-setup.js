//----------Middleware
import GetAssets from './middleware/GetAssets'
import GetSetupStatus from './middleware/GetSetupStatus'
//----------Middleware

//----------Layout
import LayoutPublic from "./../layouts/Public.vue";
//----------Layout

import SetupIndex from "./../pages/setup/Index.vue";
import InstallIndex from "./../pages/setup/install/Index.vue";
import InstallConfiguration from "./../pages/setup/install/Configuration.vue";
import InstallMigrate from "./../pages/setup/install/Migrate.vue";
import InstallDependencies from "./../pages/setup/install/Dependencies.vue";
import InstallAccount from "./../pages/setup/install/Account.vue";

let routes=[];

let list =     {
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
            path: '/install',
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

routes.push(list);

export default routes;
