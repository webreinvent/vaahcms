let routes= [];

import ui from "./vue-routes-ui";
import public_routes from "./vue-routes-public";
import dashboard from "./vue-routes-dashboard";
import users from "./vue-routes-users";
import roles from "./vue-routes-roles";
import advanced from "./vue-routes-advanced";
import permissions from "./vue-routes-permissions";
import settings from "./vue-routes-settings";

routes = routes.concat(ui);
routes = routes.concat(public_routes);
routes = routes.concat(dashboard);
routes = routes.concat(roles);
routes = routes.concat(advanced);
routes = routes.concat(users);
routes = routes.concat(permissions);
routes = routes.concat(settings);

export default routes;
