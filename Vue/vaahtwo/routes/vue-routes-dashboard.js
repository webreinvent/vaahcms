let routes= [];
let routes_list= [];

import Dashboard from '../pages/dashboard/Dashboard.vue'

import LayoutBackend from '../layouts/Backend.vue'

routes_list = {
    path: '/vaah/',
    component: LayoutBackend,
    props: true,
    children: [
        {
            path: '',
            name: 'dashboard',
            component: Dashboard,
            props: true
        }

    ]
};

routes.push(routes_list);

export default routes;

