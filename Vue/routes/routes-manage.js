//----------Middleware
import IsLoggedIn from './middleware/IsLoggedIn'
import GetBackendAssets from './middleware/GetBackendAssets'
//----------Middleware

//----------Layout
import LayoutBackend from "./../layouts/Backend.vue";
//----------Layout

let routes=[];

import MediaList from "./../pages/media/List.vue";
import MediaCreate from "../pages/media/Create.vue";
import MediaView from "./../pages/media/View.vue";
import MediaEdit from "./../pages/media/Edit.vue";
import TaxonomiesList from "./../pages/taxonomies/List";
import TaxonomiesCreate from "../pages/taxonomies/Create";
import TaxonomiesView from "./../pages/taxonomies/View";
import TaxonomiesEdit from "./../pages/taxonomies/Edit";

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
        },
        {
            path: 'taxonomies',
            name: 'taxonomies.list',
            component: TaxonomiesList,
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
                    name: 'taxonomies.create',
                    component: TaxonomiesCreate,
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
                    name: 'taxonomies.view',
                    component: TaxonomiesView,
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
                    name: 'taxonomies.edit',
                    component: TaxonomiesEdit,
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

    ],

};

routes.push(list);

export default routes;
