let routes= [];
let routes_list= [];

import LayoutBackend from "../layouts/Backend.vue";
import List from '../pages/registrations/List.vue'
import Form from '../pages/registrations/Form.vue'
import Item from '../pages/registrations/Item.vue'

routes_list = {

    path: '/vaah/registrations/',
    component: LayoutBackend,
    props: true,
    children: [
        {
            path: '',
            name: 'registrations.index',
            component: List,
            props: true,
            children: [
                {
                    path: 'form/:id?',
                    name: 'registrations.form',
                    component: Form,
                    props: true,
                },
                {
                    path: 'view/:id?',
                    name: 'registrations.view',
                    component: Item,
                    props: true,
                }
            ]
        }
        ]
};

routes.push(routes_list);

export default routes;

