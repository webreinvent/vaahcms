const mix = require('laravel-mix');
var fs = require('fs');
const fs_extra = require('fs-extra');
let Visualizer = require('webpack-visualizer-plugin');



/*
 |--------------------------------------------------------------------------
 | CSS
 |--------------------------------------------------------------------------
 */

mix.setPublicPath('./../../../public/vaahcms/admin/');

let theme_path = "./themes/vaahone/";

mix.sass('Resources/assets/admin/vaahone/scss/admin.scss', theme_path+'css/');


/*
 |--------------------------------------------------------------------------
 | Generate Build
 |--------------------------------------------------------------------------
 */

let path_vue = __dirname+"/Vue/vaahone/app.js";
mix.js(path_vue,  theme_path+'/builds');


mix.webpackConfig({
    watchOptions: {
        aggregateTimeout: 2000,
        poll: 20,
        ignored: [
            '/Config/',
            '/Database/',
            '/Entities/',
            '/Helpers/',
            '/Http/',
            '/Providers/',
            '/Resources/',
            '/Routes/',
            '/node_modules/',
            '/vendor/',
        ]
    },
    plugins: [
        new Visualizer()
    ],
});
