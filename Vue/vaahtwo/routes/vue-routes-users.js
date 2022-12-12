let routes= [];
let routes_list= [];

import LayoutBackend from "../layouts/Backend.vue";
import List from '../pages/users/List.vue'
import Form from '../pages/users/Form.vue'
import Item from '../pages/users/Item.vue'
import UserRole from '../pages/users/ViewRole.vue';

routes_list = {

    path: '/vaah/users/',
    component: LayoutBackend,
    props: true,
    children: [
        {
            path: '',
            name: 'users.index',
            component: List,
            props: true,
            children: [
                {
                    path: 'form/:id?',
                    name: 'users.form',
                    component: Form,
                    props: true,
                },
                {
                    path: 'view/:id?',
                    name: 'users.view',
                    component: Item,
                    props: true,
                },
                {
                    path: 'role/:id',
                    name: 'users.role',
                    component: UserRole,
                    props: true,
                }
            ]
        }
    ]
};

routes.push(routes_list);

export default routes;

