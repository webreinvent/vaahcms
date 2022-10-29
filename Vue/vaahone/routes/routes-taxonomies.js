import TaxonomiesList from "./../pages/taxonomies/List";
import TaxonomiesCreate from "../pages/taxonomies/Create";
import TaxonomiesView from "./../pages/taxonomies/View";
import TaxonomiesEdit from "./../pages/taxonomies/Edit";

import GetAssets from './middleware/GetAssets'
import LayoutBackend from "./../layouts/Backend";

let routes_taxonomies=[];

let list =     {
    path: '/taxonomies',
    component: LayoutBackend,
    props: true,
    meta: {
        middleware: [
            GetAssets
        ]
    },
    children: [
        {
            path: '/',
            name: 'taxonomies.list',
            component: TaxonomiesList,
            props: true,
            meta: {
                middleware: [
                    GetAssets
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
                            GetAssets
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
                            GetAssets
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
                            GetAssets
                        ]
                    },
                }

            ]
        }

    ]
};


routes_taxonomies.push(list);

export default routes_taxonomies;