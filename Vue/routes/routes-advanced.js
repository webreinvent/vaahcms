//----------Middleware
import IsLoggedIn from './middleware/IsLoggedIn'
import GetBackendAssets from './middleware/GetBackendAssets'
//----------Middleware

//----------Layout
import LayoutBackend from "./../layouts/Backend";
//----------Layout

let routes=[];

import AdvancedLayout from "./../pages/advanced/AdvancedLayout";

import Batches from "./../pages/advanced/batches/Index";
import Jobs from "./../pages/advanced/jobs/Index";
import JobsFailed from "./../pages/advanced/jobs-failed/Index";


import Logs from "./../pages/advanced/logs/Index";
import LogsItem from "./../pages/advanced/logs/Item";

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
                    name: 'batches.index',
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
                    name: 'jobs.index',
                    component: Jobs,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
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
                    name: 'logs.index',
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
