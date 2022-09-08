const mix = require('laravel-mix');
var fs = require('fs');
const fs_extra = require('fs-extra');
let Visualizer = require('webpack-visualizer-plugin');


let theme_name = 'vaahone';
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
    mix.setPublicPath(publish_folder);

    /**
     * vaahone css
     */
    output_theme_folder = "./"+theme_name+"/";
    source_theme_folder = "Resources/assets/backend/"+theme_name;
    mix.sass(source_theme_folder+'/scss/build.scss', output_theme_folder+'css/');
    mix.sass(source_theme_folder+'/scss/style.scss', output_theme_folder+'css/');

    /**
     * vaahone js
     */
    source_vue_folder = __dirname+'/Vue';
    //mix.js(__dirname+"/VueUI/app.js",  output_theme_folder+'/builds/ui.js').vue();
    mix.js(__dirname+"/Vue/app.js",  output_theme_folder+'/builds/app.js').vue();
    mix.js(__dirname+"/Vue/app-extended.js",  output_theme_folder+'/builds/app-extended.js').vue();


    /**
     * vaahprime
     */
    theme_name = 'vaahprime';
    output_theme_folder = "Resources/assets/backend/"+theme_name+"/";
    source_theme_folder = "Resources/assets/backend/"+theme_name;
    mix.combine([
        source_theme_folder+'/css/bootstrap4-light-blue/theme.css',
        source_theme_folder+'/css/primevue.min.css',
        source_theme_folder+'/css/primeflex-3.1.2/primeflex.css',
        source_theme_folder+'/css/primeicons.css',
    ], output_theme_folder+'css/build.css');


} else {

    publish_folder = './../../public/vaahcms/backend/';
    output_theme_folder = "./"+theme_name+"/";
    source_theme_folder = "Resources/assets/backend/"+theme_name;
    source_vue_folder = __dirname+'/Resources/views/backend/'+theme_name+'/vue';

    mix.setPublicPath(publish_folder);

    mix.sass(source_theme_folder+'/scss/build.scss', output_theme_folder+'css/');
    mix.sass(source_theme_folder+'/scss/style.scss', output_theme_folder+'css/');

    //mix.js(__dirname+"/VueUI/app.js",  output_theme_folder+'/builds/ui.js').vue();

    mix.js(__dirname+"/Vue/app.js",  output_theme_folder+'/builds/app.js').vue();
    //mix.js(__dirname+"/Vue/app.js",  output_theme_folder+'/builds/app.js').sourceMaps();
    mix.js(__dirname+"/Vue/app-extended.js",  output_theme_folder+'/builds/app-extended.js').vue();

}

mix.webpackConfig({
    //devtool: 'eval-source-map',
    watchOptions: {

        aggregateTimeout: 2000,
        poll: 1000,
        ignored: [
            '**/*.php',
            '**/node_modules',
            '/Config/',
            '/Database/',
            '/Helpers/',
            '/Http/',
            '/jobs/',
            '/Libraries/',
            '/Mails/',
            '/Models/',
            '/node_modules/',
            '/Notifications/',
            '/Providers/',
            '/Resources/',
            '/Routes/',
            '/Tests/',
            '/Wiki/',
        ]
    },
    plugins: [
        //new Visualizer()
    ],
});
