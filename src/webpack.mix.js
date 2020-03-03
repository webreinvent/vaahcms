const mix = require('laravel-mix');
var fs = require('fs');
const fs_extra = require('fs-extra');



/*
 |--------------------------------------------------------------------------
 | CSS
 |--------------------------------------------------------------------------
 */

mix.setPublicPath('./../../../public/vaahcms/admin/');

let theme_path = "./themes/vaahone/";

mix.sass('Resources/assets/admin/vaahone/scss/admin.scss', theme_path+'css/');

/*
mix.sass('Resources/assets/sass/custom.scss', './css/custom.css').options({
     processCssUrls: false
});
*/

/*
 |--------------------------------------------------------------------------
 | Copy Assets
 |--------------------------------------------------------------------------
 */
/*

let to_path = './../../../public/vaahcms/themes/themerxconnect/assets';
let from_path = __dirname+"/Resources/assets";

mix.copy(from_path, to_path);
*/


/*
 |--------------------------------------------------------------------------
 | Generate Build
 |--------------------------------------------------------------------------
 */

var path_vue = __dirname+"/Vue/vaahone/app.js";
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
    }
});
