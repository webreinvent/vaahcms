let routes= [];
let routes_list= [];

import LayoutBackend from "../layouts/Backend.vue";
import List from '../pages/permissions/List.vue'
import Form from '../pages/permissions/Form.vue'
import Item from '../pages/permissions/Item.vue'

routes_list = {

    path: '/vaah/permissions/',
    component: LayoutBackend,
    props: true,
    children: [
        {
            path: '',
            name: 'permissions.index',
            component: List,
            props: true,
            children: [
                {
                    path: 'form/:id?',
                    name: 'permissions.form',
                    component: Form,
                    props: true,
                },
                {
                    path: 'view/:id?',
                    name: 'permissions.view',
                    component: Item,
                    props: true,
                }
            ]
        }
    ]
};

routes.push(routes_list);

export default routes;

