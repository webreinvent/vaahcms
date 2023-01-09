let routes= [];
let routes_list= [];

import LayoutBackend from "../layouts/Backend.vue";
import AdvancedLayout from "../pages/advanced/AdvancedLayout.vue";
import List from '../pages/advanced/jobs/List.vue'
import Form from '../pages/advanced/jobs/Form.vue'
import Item from '../pages/advanced/jobs/Item.vue'
import FailedJobList from '../pages/advanced/failedjobs/List.vue'
import FailedJobForm from '../pages/advanced/failedjobs/Form.vue'
import FailedJobItem from '../pages/advanced/failedjobs/Item.vue'

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

                    path: 'failedjobs',
                    name: 'failedjobs.index',
                    component: FailedJobList,
                    props: true,
                    children: [
                        {
                            path: 'form/:id?',
                            name: 'faiedjobs.form',
                            component: FailedJobList,
                            props: true,
                        },
                        {
                            path: 'view/:id?',
                            name: 'faiedjobs.view',
                            component: FailedJobList,
                            props: true,
                        }
                    ]
                }
            ]
        }
    ]
};

routes.push(routes_list);

export default routes;

