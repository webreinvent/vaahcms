let routes= [];
let routes_list= [];

import LayoutBackend from "../layouts/Backend.vue";
import Profile from '../pages/profile/index.vue'

routes_list = {

    path: '/vaah/users/',
    component: LayoutBackend,
    props: true,
    children: [
        {
            path: '/vaah/profile',
            name: 'profile',
            component: Profile,
            props: true,
        }
    ]
};

routes.push(routes_list);

export default routes;

