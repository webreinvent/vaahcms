let routes= [];
let routes_list= [];

import List from '../pages/taxonomies/List.vue'
import Form from '../pages/taxonomies/Form.vue'
import Item from '../pages/taxonomies/Item.vue'

routes_list = {

    path: '/manage/taxonomies',
    name: 'taxonomies.index',
    component: List,
    props: true,
    children:[
        {
            path: 'form/:id?',
            name: 'taxonomies.form',
            component: Form,
            props: true,
        },
        {
            path: 'view/:id?',
            name: 'taxonomies.view',
            component: Item,
            props: true,
        }
    ]
};

routes.push(routes_list);

export default routes;

