let routes= [];
let routes_list= [];

import LayoutBackend from "../layouts/Backend.vue";
import List from '../pages/jobs/List.vue'
import Form from '../pages/jobs/Form.vue'
import Item from '../pages/jobs/Item.vue'

routes_list = {

    path: '/vaah/advanced/jobs/',
    component: LayoutBackend,
    props: true,
    children: [
        {

            path: '',
            name: 'jobs.index',
            component: List,
            props: true,
            children: [
                {
                    path: 'form/:id?',
                    name: 'jobs.form',
                    component: Form,
                    props: true,
                },
                {
                    path: 'view/:id?',
                    name: 'jobs.view',
                    component: Item,
                    props: true,
                }
            ]
        }
    ]
};

routes.push(routes_list);

export default routes;
