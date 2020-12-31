//----------Middleware
import IsLoggedIn from './middleware/IsLoggedIn'
import GetBackendAssets from './middleware/GetBackendAssets'
//----------Middleware

//----------Layout
import LayoutBackend from "./../layouts/Backend";
//----------Layout

let routes=[];

import MediaList from "./../pages/media/List";
import MediaCreate from "../pages/media/Create.vue";
import MediaView from "./../pages/media/View";
import MediaEdit from "./../pages/media/Edit";

let list =     {
    path: '/vaah/manage',
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
            path: 'media',
            name: 'media.list',
            component: MediaList,
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
                    name: 'media.create',
                    component: MediaCreate,
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
                    name: 'media.view',
                    component: MediaView,
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
                    name: 'media.edit',
                    component: MediaEdit,
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

routes.push(list);

export default routes;
