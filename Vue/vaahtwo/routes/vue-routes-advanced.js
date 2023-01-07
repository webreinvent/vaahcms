let routes= [];
let routes_list= [];

import LayoutBackend from "../layouts/Backend.vue";
import AdvancedLayout from "../pages/advanced/AdvancedLayout.vue";
import JobList from '../pages/advanced/jobs/List.vue'
import JobForm from '../pages/advanced/jobs/Form.vue'
import JobItem from '../pages/advanced/jobs/Item.vue'
import LogList from '../pages/advanced/logs/List.vue'
import LogForm from '../pages/advanced/logs/Form.vue'
import LogItem from '../pages/advanced/logs/Item.vue'
import FailedJobList from '../pages/advanced/failedjobs/List.vue'
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

                    path: 'logs',
                    name: 'logs.index',
                    component: LogList,
                    props: true,
                    children: [
                        {
                            path: 'form/:id?',
                            name: 'logs.form',
                            component: LogForm,
                            props: true,
                        },
                        {
                            path: 'view/:id?',
                            name: 'logs.view',
                            component: LogItem,
                            props: true,
                        }
                    ]
                },
                {

                    path: 'jobs',
                    name: 'jobs.index',
                    component: JobList,
                    props: true,
                    children: [
                        {
                            path: 'form/:id?',
                            name: 'jobs.form',
                            component: JobForm,
                            props: true,
                        },
                        {
                            path: 'view/:id?',
                            name: 'jobs.view',
                            component: JobItem,
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
                            path: 'view/:id?',
                            name: 'faiedjobs.view',
                            component: FailedJobItem,
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

