//----------Middleware
import IsLoggedIn from './middleware/IsLoggedIn'
import GetBackendAssets from './middleware/GetBackendAssets'
//----------Middleware

//----------Layout
import LayoutBackend from "./../layouts/Backend";
//----------Layout

let routes=[];

import PermList from "./../pages/permissions/List";
import PermView from "./../pages/permissions/View";
import PermRole from "./../pages/permissions/ViewRole";
import PermEdit from "./../pages/permissions/Edit";

let list =     {
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

routes.push(list);

export default routes;
