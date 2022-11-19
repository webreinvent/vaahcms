const mix = require('laravel-mix');


let theme_name = 'vaahtwo';
let resource_path = './../../Resources/assets/backend/';
let theme_path = resource_path+theme_name+'/';
let build_path = './../../Resources/assets/backend/build/';
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

    publish_folder = build_path;
    mix.setPublicPath(publish_folder);

    mix.sass(theme_path+'/scss/build.scss', build_path+'vaahtwo.css').options({ processCssUrls: false })


    /**
     * vaahone css
     */
    theme_name = 'vaahone';
    theme_path = './../../Resources/assets/backend/'+theme_name+'/';
    mix.sass(theme_path+'/scss/build.scss', build_path+'vaahone.css').options({ processCssUrls: false })



} else if(mode !== 'publish') {
    publish_folder = './../../Resources/assets/backend/';
    mix.setPublicPath(publish_folder);

    mix.sass(theme_path+'/scss/build.scss', theme_path+'build/vaahtwo.css');


    // vaahone css
    theme_name = 'vaahone';
    theme_path = './../../Resources/assets/backend/'+theme_name+'/';
    mix.sass(theme_path+'/scss/build.scss', theme_path+'build/vaahone.css');
}


console.log('mode--->', mode);



if(mode === 'publish')
{
    let source_path = './../../Resources/assets/backend/build';
    let output_path = __dirname+'/../../../../public/vaahcms/backend/build'
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
