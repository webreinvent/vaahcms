/*
 |--------------------------------------------------------------------------
 |
 | This webpack file is to create the development environment for vaahcms
 | replace root webpack file with this file
 |
 */

const mix = require('laravel-mix');
var fs = require('fs');
const fs_extra = require('fs-extra');


/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */


var root_path = "./../../";

var admin_path = root_path+'resources/assets/vendor/vaahcms/admin/';
var admin_default_theme_path = admin_path+'default/';

mix.setPublicPath(admin_default_theme_path);

var admin_assets_json = JSON.parse(fs.readFileSync(admin_default_theme_path+'assets.json'));

//console.log(admin_assets_json);

var admin_copy_path = root_path+'resources/assets/vendor/vaahcms/admin/';
var admin_copy_path_des = root_path+'packages/vaahcms/src/Resources/assets/admin/';

fs_extra.removeSync(admin_copy_path_des);

mix.combine(admin_assets_json['css'], admin_default_theme_path+'builds/vaahcms.css')
    .combine(admin_assets_json['js'], admin_default_theme_path+'builds/vaahcms.js')
    .js(admin_default_theme_path+'vue/app-setup.js',  './builds')
    .js(admin_default_theme_path+'vue/login/app-login.js',  './builds')
    .js(admin_default_theme_path+'vue/app-dashboard.js',  './builds')
    .js(admin_default_theme_path+'vue/app-modules.js',  './builds')
    .js(admin_default_theme_path+'vue/app-themes.js',  './builds')
    .js(admin_default_theme_path+'vue/registrations/app-registrations.js',  './builds')
    .js(admin_default_theme_path+'vue/users/app-users.js',  './builds')
    .js(admin_default_theme_path+'vue/roles/app-roles.js',  './builds')
    .js(admin_default_theme_path+'vue/permissions/app-permissions.js',  './builds')
    .copyDirectory(admin_copy_path, admin_copy_path_des, false)
    .version();


mix.webpackConfig({
    watchOptions: {
        aggregateTimeout: 2000,
        poll: 20,
        ignored: [
            '/app/',
            '/bootstrap/',
            '/config/',
            '/database/',
            '/packages/',
            '/public/',
            '/routes/',
            '/storage/',
            '/tests/',
            '/vaahcms/',
            '/node_modules/',
            '/vendor/',

        ]
    }
});