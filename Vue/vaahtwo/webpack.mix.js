const mix = require('laravel-mix');


let theme_name = 'vaahtwo';
let theme_path = './../../Resources/assets/backend/'+theme_name+'/';
let publish_folder;

if (mix.inProduction()) {
/*
 |--------------------------------------------------------------------------
 | Only in Production
 |--------------------------------------------------------------------------
 */
    console.log('---------------------');
    console.log('IN PRODUCTION MODE');
    console.log('---------------------');

    publish_folder = './../../Resources/assets/backend/';
    mix.setPublicPath(publish_folder);

    mix.combine([
        theme_path+'/css/bootstrap4-light-blue/theme.css',
        theme_path+'/css/primevue.min.css',
        theme_path+'/css/primeflex-3.1.2/primeflex.css',
        theme_path+'/css/primeicons.css',
        theme_path+'/css/style.css',
    ], theme_path+'css/build.css');


    /**
     * vaahone css
     */
    theme_name = 'vaahone';
    theme_path = './../../Resources/assets/backend/'+theme_name+'/';
    mix.sass(theme_path+'/scss/build.scss', theme_path+'css/');
    mix.sass(theme_path+'/scss/style.scss', theme_path+'css/');


} else {

    publish_folder = './../../Resources/assets/backend/';
    mix.setPublicPath(publish_folder);

    mix.combine([
        theme_path+'/css/bootstrap4-light-blue/theme.css',
        theme_path+'/css/primevue.min.css',
        theme_path+'/css/primeflex-3.1.2/primeflex.css',
        theme_path+'/css/primeicons.css',
        theme_path+'/css/style.css',
    ], theme_path+'css/build.css');

    /**
     * vaahone css
     */
    theme_name = 'vaahone';
    theme_path = './../../Resources/assets/backend/'+theme_name+'/';


    mix.sass(theme_path+'/scss/build.scss', theme_path+'css/');
    mix.sass(theme_path+'/scss/style.scss', theme_path+'css/');

}


mix.options({
    hmrOptions: {
        host: 'localhost',
        port: 4001,
},
});

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
    ],
});
