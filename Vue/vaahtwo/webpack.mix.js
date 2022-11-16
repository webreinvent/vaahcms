const mix = require('laravel-mix');


let theme_name = 'vaahtwo';
let theme_path = './../../Resources/assets/backend/'+theme_name+'/';
let publish_folder;


let mode = process.argv[5];

console.log('--->', mode);


if (mix.inProduction()) {
/*
 |--------------------------------------------------------------------------
 | Only in Production
 |--------------------------------------------------------------------------
 */
    console.log('---------------------');
    console.log('IN PRODUCTION MODE');
    console.log('---------------------');

    publish_folder = './../../Resources/assets/backend/'+theme_path+'/';
    //mix.setResourceRoot(publish_folder+'/vaahtwo/build')
    mix.setPublicPath(publish_folder);

    mix.sass(theme_path+'scss/build.scss', theme_path+'build/');

    /*mix.combine([
       // theme_path+'/css/lara-light-theme/theme.css',
        theme_path+'/css/tailwind-light/theme.css',
        theme_path+'/css/primevue.min.css',
        theme_path+'/css/primeflex-3.2.1/primeflex.css',
        theme_path+'/css/primeicons.css',
    ], theme_path+'build/build.css');*/


    /**
     * vaahone css
     */
    /*theme_name = 'vaahone';
    theme_path = './../../Resources/assets/backend/'+theme_name+'/';
    mix.sass(theme_path+'/scss/build.scss', theme_path+'css/');
    mix.sass(theme_path+'/scss/style.scss', theme_path+'css/');*/


} else if(mode !== 'publish') {
    publish_folder = './../../Resources/assets/backend/';
    mix.setPublicPath(publish_folder);


    mix.sass(theme_path+'/scss/style.scss', theme_path+'build/style.css');

    mix.combine([
        // theme_path+'/css/lara-light-theme/theme.css',
        theme_path+'/css/tailwind-light/theme.css',
        theme_path+'/css/primevue.min.css',
        theme_path+'/css/primeflex-3.2.1/primeflex.css',
        theme_path+'/css/primeicons.css',
    ], theme_path+'build/build.css');



    // vaahone css
    theme_name = 'vaahone';
    theme_path = './../../Resources/assets/backend/'+theme_name+'/';

    mix.sass(theme_path+'/scss/build.scss', theme_path+'css/');
    mix.sass(theme_path+'/scss/style.scss', theme_path+'css/');
}


console.log('mode--->', mode);



if(mode === 'publish')
{
    let source_path = './../../Resources/assets/backend/';
    let output_path = __dirname+'/../../../../public/vaahcms/backend'
    mix.copy(source_path, output_path);
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
