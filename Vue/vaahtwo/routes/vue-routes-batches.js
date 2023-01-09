let routes= [];
let routes_list= [];

import LayoutBackend from "../layouts/Backend.vue";
import List from '../pages/batches/List.vue'
import Form from '../pages/batches/Form.vue'
import Item from '../pages/batches/Item.vue'

routes_list = {
    path: '/vaah/advanced/batches',
    component: LayoutBackend,
    props: true,
    children: [
        {
            path: '',
            name: 'batches.index',
            component: List,
            props: true,
            children: [
                {
                    path: 'form/:id?',
                    name: 'batches.form',
                    component: Form,
                    props: true,
                },
                {
                    path: 'view/:id?',
                    name: 'batches.view',
                    component: Item,
                    props: true,
                }
            ]
        }
    ]
};

routes.push(routes_list);

export default routes;

