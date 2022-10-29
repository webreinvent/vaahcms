//----------Middleware
import IsLoggedIn from './middleware/IsLoggedIn'
import GetBackendAssets from './middleware/GetBackendAssets'
//----------Middleware

//----------Layout
import LayoutBackend from "./../layouts/Backend.vue";
//----------Layout

let routes=[];

import ModuleList from "./../pages/modules/List.vue";
import ModuleView from "./../pages/modules/View.vue";
import ModuleInstall from "./../pages/modules/Install.vue";

let list =     {
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


routes.push(list);

export default routes;
