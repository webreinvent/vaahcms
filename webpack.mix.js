const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');
var fs = require('fs');
const fs_extra = require('fs-extra');

let input_path = __dirname+'/src/Resources/assets/admin/default';
let output_path = "src/Resources/assets/admin/default/";
let resource_path = '../../public/vendor/vaahcms/admin/default';
var admin_assets_json = JSON.parse(fs.readFileSync(input_path+'/assets.json'));

mix.setPublicPath(output_path).mergeManifest();

mix.combine(admin_assets_json['css'], output_path+'/css/vaahcms.css')
    .combine(admin_assets_json['js'], output_path+'/js/vaahcms.js')
    .js(input_path+'/vue/app-setup.js', 'builds/')
    .js(input_path+'/vue/app-login.js', 'builds/')
    .js(input_path+'/vue/app.js', 'builds/')
    .copyDirectory(input_path, resource_path, false);



/*mix.copyDirectory(input_path+'/builds', resource_path, false);
mix.copyDirectory(input_path+'/css', resource_path, false);
mix.copyDirectory(input_path+'/js', resource_path, false);


let public_path = '../../public/vendor/vaahcms/admin/default';
mix.copyDirectory(input_path+'/builds', public_path+'/builds', false);
mix.copyDirectory(input_path+'/css', public_path+'/css', false);
mix.copyDirectory(input_path+'/js', public_path+'/js', false);*/

//public/vendor/vaahcms/admin/default/builds/app.js?v=0.3.2"
/*
let to_path = './../../public/endor/vaahcms/admin/default';
mix.setPublicPath('./../../public/endor/vaahcms/admin/default/builds');


mix.combine(admin_assets_json['css'], to_path+'/css/vaahcms.css');
mix.js(input_path+'/vue/app-setup.js', './builds');

/*
mix.combine(admin_assets_json['css'], to_path+'/css/vaahcms.css')
    .combine(admin_assets_json['js'], to_path+'/js/vaahcms.js')
    .js(input_path+'/vue/app-setup.js', './builds')
    .js(input_path+'/vue/app-login.js', './builds')
    .js(input_path+'/vue/app.js', './builds')
    .copyDirectory(input_path, resource_path, false);
*/
