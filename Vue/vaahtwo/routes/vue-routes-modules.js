let routes= [];
let routes_list= [];

import LayoutBackend from '../layouts/Backend.vue';
import List from '../pages/modules/List.vue';
import Item from '../pages/modules/Item.vue';
import ModuleInstall from '../pages/modules/Install.vue';


routes_list = {
    path: '/vaah/modules/',
    component: LayoutBackend,
    props: true,
    children: [
        {
            path: '',
            name: 'modules.index',
            component: List,
            props: true,
            children:[
                {
                    path: 'view/:id?',
                    name: 'modules.view',
                    component: Item,
                    props: true,
                },
                {
                    path: 'install',
                    name: 'modules.install',
                    component: ModuleInstall,
                    props: true,
                },
            ]
        }
    ]
};

routes.push(routes_list);

export default routes;

