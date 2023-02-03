let routes= [];
let routes_list= [];

import LayoutBackend from "../layouts/Backend.vue";
import List from '../pages/media/List.vue';
import Form from '../pages/media/Form.vue';
import Item from '../pages/media/Item.vue';

routes_list = {
    path: '/vaah/manage/media/',
    component: LayoutBackend,
    props: true,
    children: [
        {
            path: '',
            name: 'media.index',
            component: List,
            props: true,
            children: [
                {
                    path: 'form/:id?',
                    name: 'media.form',
                    component: Form,
                    props: true,
                },
                {
                    path: 'view/:id?',
                    name: 'media.view',
                    component: Item,
                    props: true,
                }
            ]
        }
    ]
};

routes.push(routes_list);

export default routes;

