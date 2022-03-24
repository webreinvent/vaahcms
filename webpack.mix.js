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

    output_theme_folder = "./"+theme_name+"/";
    source_theme_folder = "Resources/assets/backend/"+theme_name;

    source_vue_folder = __dirname+'/Vue';

    mix.setPublicPath(publish_folder);

    mix.sass(source_theme_folder+'/scss/build.scss', output_theme_folder+'css/');
    mix.sass(source_theme_folder+'/scss/style.scss', output_theme_folder+'css/');


    //mix.js(__dirname+"/VueUI/app.js",  output_theme_folder+'/builds/ui.js').vue();
    mix.js(__dirname+"/Vue/app.js",  output_theme_folder+'/builds/app.js').vue();
    mix.js(__dirname+"/Vue/app-extended.js",  output_theme_folder+'/builds/app-extended.js').vue();


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

    module:{
        rules: [
            {
                test: /\.s[ac]ss$/i,
                use: [
                    {
                        loader: 'sass-loader',
                        options: {
                            implementation: require('node-sass')
                        }
                    }
                ]
            }
        ]
    },
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
