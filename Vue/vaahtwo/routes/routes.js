let routes= [];

import ui from "./vue-routes-ui";
import public_routes from "./vue-routes-public";
import dashboard from "./vue-routes-dashboard";

routes = routes.concat(ui);
routes = routes.concat(public_routes);
routes = routes.concat(dashboard);

export default routes;
