//----------Middleware
import IsLoggedIn from './middleware/IsLoggedIn'
import GetBackendAssets from './middleware/GetBackendAssets'
//----------Middleware

//----------Layout
import LayoutBackend from "./../layouts/Backend.vue";
//----------Layout

let routes=[];

import RoleList from "./../pages/roles/List.vue";
import RoleCreate from "../pages/roles/Create.vue";
import RoleView from "./../pages/roles/View.vue";
import RoleViewPermission from "./../pages/roles/ViewPermission.vue";
import RoleViewUser from "./../pages/roles/ViewUser.vue";
import RoleEdit from "./../pages/roles/Edit.vue";

let list =     {
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

routes.push(list);

export default routes;
