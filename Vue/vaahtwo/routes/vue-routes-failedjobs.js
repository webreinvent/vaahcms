let routes= [];
let routes_list= [];

import List from '../pages/advanced/failedjobs/List.vue'
import Item from '../pages/advanced/failedjobs/Item.vue'

routes_list = {

    path: '/failedjobs',
    name: 'failedjobs.index',
    component: List,
    props: true,
    children:[
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

