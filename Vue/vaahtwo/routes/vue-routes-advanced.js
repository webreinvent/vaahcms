let routes= [];
let routes_list= [];

import LayoutBackend from "../layouts/Backend.vue";
import AdvancedLayout from "../pages/advanced/AdvancedLayout.vue";
import JobList from '../pages/advanced/jobs/List.vue'
import LogList from '../pages/advanced/logs/List.vue'
import LogItem from '../pages/advanced/logs/Item.vue'
import FailedJobList from '../pages/advanced/failedjobs/List.vue'
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

                    path: 'logs',
                    name: 'logs.index',
                    component: LogList,
                    props: true,
                    children: [
                        {
                            path: 'view/:name?',
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
                },
                {

                    path: 'failedjobs',
                    name: 'failedjobs.index',
                    component: FailedJobList,
                    props: true,
                },
                {
                    path: 'batches',
                    name: 'batches.index',
                    component: BatchList,
                    props: true
                }
            ]
        }
    ]
};

routes.push(routes_list);

export default routes;

