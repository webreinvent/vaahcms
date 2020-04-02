const mix = require('laravel-mix');
var fs = require('fs');
const fs_extra = require('fs-extra');
let Visualizer = require('webpack-visualizer-plugin');



/*
 |--------------------------------------------------------------------------
 | CSS
 |--------------------------------------------------------------------------
 */

mix.setPublicPath('./../../../public/vaahcms/backend/');

let theme_path = "./themes/vaahone/";

mix.sass('Resources/assets/backend/vaahone/scss/vaahcms.scss', theme_path+'css/');
mix.sass('Resources/assets/backend/vaahone/scss/backend.scss', theme_path+'css/');


let path_vue;

/*
 |--------------------------------------------------------------------------
 | UI Build
 |--------------------------------------------------------------------------
 */

/*path_vue = __dirname+"/Resources/views/backend/vaahone/vue/ui/app.js";
mix.js(path_vue,  theme_path+'/builds/ui.js');*/

/*
 |--------------------------------------------------------------------------
 | App Build
 |--------------------------------------------------------------------------
 */

path_vue = __dirname+"/Resources/views/backend/vaahone/vue/app/app.js";
mix.js(path_vue,  theme_path+'/builds/app.js');

//--------------------------------------------------------------------------

mix.webpackConfig({
    watchOptions: {
        aggregateTimeout: 2000,
        poll: 20,
        ignored: [
            '/Config/',
            '/Database/',
            '/Entities/',
            '/Facades/',
            '/Helpers/',
            '/Http/',
            '/Libraries/',
            '/Loaders/',
            '/Observers/',
            '/Providers/',
            '/Resources/',
            '/Routes/',
            '/node_modules/',
            '/Tests/',
            '/Traits/',
        ]
    },
    plugins: [
        new Visualizer()
    ],
});
