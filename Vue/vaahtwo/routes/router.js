import { createRouter,  createWebHashHistory  } from 'vue-router'
import qs from 'qs';

import routes from "./routes";
import Default from "../layouts/Default.vue";


const router = createRouter({
  history: createWebHashHistory(),
  routes: [
      {
          path: '/',
          component: Default,
          props: true,
          children: routes
      }
  ],
    parseQuery(query) {
        return qs.parse(query);
    },
    stringifyQuery(query) {
        let result = qs.stringify(query,
            {
                arrayFormat: 'brackets',
                encode: false,
                skipNulls: true
            });
        //return result ? ('?' + result) : '';
        return result;
    }
})

export default router
