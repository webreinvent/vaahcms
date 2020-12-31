//----------Middleware
import IsLoggedIn from './middleware/IsLoggedIn'
import GetBackendAssets from './middleware/GetBackendAssets'
//----------Middleware

//----------Layout
import LayoutBackend from "./../layouts/Backend";
//----------Layout

let routes=[];

import ThemeList from "./../pages/themes/List";
import ThemeView from "./../pages/themes/View";
import ThemeInstall from "./../pages/themes/Install";

let list =     {
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

routes.push(list);

export default routes;
