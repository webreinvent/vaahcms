let routes= [];
let routes_list= [];

import List from '../pages/advanced/failedjobs/List.vue'
import Form from '../pages/advanced/failedjobs/Form.vue'
import Item from '../pages/advanced/failedjobs/Item.vue'

routes_list = {

    path: '/failedjobs',
    name: 'failedjobs.index',
    component: List,
    props: true,
    children:[
        {
            path: 'form/:id?',
            name: 'failedjobs.form',
            component: Form,
            props: true,
        },
        {
            path: 'view/:id?',
            name: 'failedjobs.view',
            component: Item,
            props: true,
        }
    ]
};

routes.push(routes_list);

export default routes;

