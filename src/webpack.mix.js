const mix = require('laravel-mix');
var fs = require('fs');
const fs_extra = require('fs-extra');
let Visualizer = require('webpack-visualizer-plugin');



let publish_folder;
let output_theme_folder;
let source_theme_folder;
let source_vue_folder;




if (mix.inProduction()) {
/*
 |--------------------------------------------------------------------------
 | Only in Production
 |--------------------------------------------------------------------------
 */
    console.log('this is visible in production');

    publish_folder = './Resources/assets/backend/';
    output_theme_folder = "./themes/vaahone/";
    source_theme_folder = "Resources/assets/backend/vaahone";
    source_vue_folder = __dirname+'/Resources/views/backend/vaahone/vue';

    mix.setPublicPath(publish_folder);

    mix.sass(source_theme_folder+'/scss/vaahcms.scss', output_theme_folder+'css/');
    mix.sass(source_theme_folder+'/scss/backend.scss', output_theme_folder+'css/');


    mix.js(source_vue_folder+"/ui/app.js",  output_theme_folder+'/builds/ui.js');
    mix.js(source_vue_folder+"/app/app.js",  output_theme_folder+'/builds/app.js');


} else {

    publish_folder = './../../../public/vaahcms/backend/';
    output_theme_folder = "./themes/vaahone/";
    source_theme_folder = "Resources/assets/backend/vaahone";
    source_vue_folder = __dirname+'/Resources/views/backend/vaahone/vue';

    mix.setPublicPath(publish_folder);

    mix.sass(source_theme_folder+'/scss/vaahcms.scss', output_theme_folder+'css/');
    mix.sass(source_theme_folder+'/scss/backend.scss', output_theme_folder+'css/');


    mix.js(source_vue_folder+"/ui/app.js",  output_theme_folder+'/builds/ui.js');
    mix.js(source_vue_folder+"/app/app.js",  output_theme_folder+'/builds/app.js');

}

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
