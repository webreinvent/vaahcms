let routes= [];
let routes_list= [];

import Profile from '../pages/profile/Profile.vue'

routes_list = {
    path: '/vaah/profile',
    name: 'profile',
    component: Profile,
    props: true,
};

routes.push(routes_list);

export default routes;

