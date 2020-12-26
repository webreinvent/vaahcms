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
    console.log('---------------------');
    console.log('IN PRODUCTION MODE');
    console.log('---------------------');

    publish_folder = './Resources/assets/backend/';
    output_theme_folder = "./vaahone/";
    source_theme_folder = "Resources/assets/backend/vaahone";
    source_vue_folder = __dirname+'/Vue';

    mix.setPublicPath(publish_folder);

    mix.sass(source_theme_folder+'/scss/vaahcms.scss', output_theme_folder+'css/');
    mix.sass(source_theme_folder+'/scss/backend.scss', output_theme_folder+'css/');


    mix.js(__dirname+"/VueUI/app.js",  output_theme_folder+'/builds/ui.js');
    mix.js(__dirname+"/Vue/app.js",  output_theme_folder+'/builds/app.js');
    mix.js(__dirname+"/Vue/app-extended.js",  output_theme_folder+'/builds/app-extended.js');


} else {

    publish_folder = './../../public/vaahcms/backend/';
    output_theme_folder = "./vaahone/";
    source_theme_folder = "Resources/assets/backend/vaahone";
    source_vue_folder = __dirname+'/Resources/views/backend/vaahone/vue';

    mix.setPublicPath(publish_folder);

    mix.sass(source_theme_folder+'/scss/vaahcms.scss', output_theme_folder+'css/');
    mix.sass(source_theme_folder+'/scss/backend.scss', output_theme_folder+'css/');

    mix.js(__dirname+"/VueUI/app.js",  output_theme_folder+'/builds/ui.js');
    mix.js(__dirname+"/Vue/app.js",  output_theme_folder+'/builds/app.js');
    mix.js(__dirname+"/Vue/app-extended.js",  output_theme_folder+'/builds/app-extended.js');

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
        //new Visualizer()
    ],
});
