let routes= [];
let routes_list= [];

import LayoutBackend from "../layouts/Backend.vue";
import AdvancedLayout from "../pages/advanced/AdvancedLayout.vue";
import List from '../pages/advanced/jobs/List.vue'
import Form from '../pages/advanced/jobs/Form.vue'
import Item from '../pages/advanced/jobs/Item.vue'
import BatchList from '../pages/advanced/batches/List.vue'

routes_list = {

    path: '/vaah/advanced/',
    component: LayoutBackend,
    props: true,
    children: [
        {
            path: '',
            component: AdvancedLayout,
            props: true,
            children: [
                {
                    path: 'jobs',
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
                },
                {
                    path: 'batches',
                    name: 'batches.index',
                    component: BatchList,
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
        },
    ]
};

routes.push(routes_list);

export default routes;

