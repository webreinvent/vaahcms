let routes= [];
let routes_list= [];

import LayoutBackend from "../layouts/Backend.vue";
import List from '../pages/roles/List.vue'
import Form from '../pages/roles/Form.vue'
import Item from '../pages/roles/Item.vue'
import ViewPermission from '../pages/roles/ViewPermission.vue'
import ViewUser from '../pages/roles/ViewUser.vue'


routes_list = {
    path: '/vaah/roles/',
    component: LayoutBackend,
    props: true,
    children: [
        {
            path: '',
            name: 'roles.index',
            component: List,
            props: true,
            children:[
                {
                    path: 'form/:id?',
                    name: 'roles.form',
                    component: Form,
                    props: true,
                },
                {
                    path: 'view/:id?',
                    name: 'roles.view',
                    component: Item,
                    props: true,
                },
                {
                    path: 'permissions/:id?',
                    name: 'roles.permissions',
                    component: ViewPermission,
                    props: true,
                },
                {
                    path: 'users/:id?',
                    name: 'roles.users',
                    component: ViewUser,
                    props: true,
                }
            ]
        }

    ]
};

routes.push(routes_list);

export default routes;

