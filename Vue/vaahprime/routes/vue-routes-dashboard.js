let routes= [];
let routes_list= [];

import Dashboard from '../pages/dashboard/Dashboard.vue'

routes_list = {
    path: '/',
    name: 'dashboard',
    component: Dashboard,
    props: true,
};

routes.push(routes_list);

export default routes;

