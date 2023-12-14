let routes= [];
let routes_list= [];

import LayoutBackend from '../layouts/Backend.vue';
import List from '../pages/themes/List.vue';
import Item from '../pages/themes/Item.vue';
import ThemeInstall from '../pages/themes/Install.vue';

routes_list = {
    path: '/vaah/themes/',
    component: LayoutBackend,
    props: true,
    children: [
        {
            path: '',
            name: 'themes.index',
            component: List,
            props: true,
            children:[
                {
                    path: 'view/:id?',
                    name: 'themes.view',
                    component: Item,
                    props: true,
                },
                {
                    path: 'install',
                    name: 'themes.install',
                    component: ThemeInstall,
                    props: true,
                }
            ]
        }
    ]
};

routes.push(routes_list);

export default routes;

