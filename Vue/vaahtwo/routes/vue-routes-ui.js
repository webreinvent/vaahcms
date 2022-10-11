let routes= [];
let routes_list= [];

import Index from '../pages/ui/Index.vue'
import Signin from '../pages/ui/Signin.vue'

routes_list = {
    path: '/ui',
    name: 'ui.index',
    component: Index,
    props: true,
    children: [
        {
            path: 'signin',
            name: 'ui.signin',
            component: Signin,
            props: true,
        }
    ]
};

routes.push(routes_list);

export default routes;

