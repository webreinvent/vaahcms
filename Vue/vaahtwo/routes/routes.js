let routes= [];

import ui from "./vue-routes-ui";
import public_routes from "./vue-routes-public";
import dashboard from "./vue-routes-dashboard";
import users from "./vue-routes-users";
import roles from "./vue-routes-roles";
import permissions from "./vue-routes-permissions";

routes = routes.concat(ui);
routes = routes.concat(public_routes);
routes = routes.concat(dashboard);
routes = routes.concat(roles);
routes = routes.concat(permissions);
routes = routes.concat(users);

export default routes;
