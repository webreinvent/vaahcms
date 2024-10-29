let routes= [];
let routes_list= [];

import Signin from '../pages/public/Signin.vue'

routes_list = {
    path: '/',
    name: 'signin',
    component: Signin,
    props: true,
};

routes.push(routes_list);

export default routes;

