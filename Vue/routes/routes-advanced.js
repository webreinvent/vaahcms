//----------Middleware
import IsLoggedIn from './middleware/IsLoggedIn'
import GetBackendAssets from './middleware/GetBackendAssets'
import GetAssets from "./middleware/GetAssets";
//----------Middleware

//----------Layout
import LayoutBackend from "./../layouts/Backend.vue";
//----------Layout

let routes=[];

import AdvancedLayout from "./../pages/advanced/AdvancedLayout.vue";

import Batches from "./../pages/advanced/batches/List.vue";
import JobsFailed from "./../pages/advanced/jobs-failed/Index.vue";


import Logs from "./../pages/advanced/logs/Index.vue";
import LogsItem from "./../pages/advanced/logs/Item.vue";

import JobsList from "../pages/advanced/jobs/List";

let list =     {
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
            path: 'advanced',
            component: AdvancedLayout,
            props: true,
            meta: {
                middleware: [
                    IsLoggedIn,
                    GetBackendAssets
                ]
            },
            children: [
                {
                    path: 'batches',
                    name: 'batches.list',
                    component: Batches,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    }
                },
                {
                    path: 'jobs',
                    name: 'jobs.list',
                    component: JobsList,
                    props: true,
                    meta: {
                        middleware: [
                            GetAssets
                        ]
                    }
                },
                {
                    path: 'jobs-failed',
                    name: 'jobs.failed.index',
                    component: JobsFailed,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    }
                },
                {
                    path: 'logs',
                    name: 'logs.list',
                    component: Logs,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    },
                    children: [
                        {
                            path: 'details/:name',
                            name: 'logs.details',
                            component: LogsItem,
                            props: true,
                            meta: {
                                middleware: [
                                    IsLoggedIn,
                                    GetBackendAssets
                                ]
                            }
                        },
                    ]
                },


            ]
        }

    ]
};


routes.push(list);

export default routes;
