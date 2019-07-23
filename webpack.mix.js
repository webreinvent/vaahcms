const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');
var fs = require('fs');
const fs_extra = require('fs-extra');

let input_path = __dirname+'/src/Resources/assets/admin/default';
let output_path = "src/Resources/assets/admin/default/";
let resource_path = '../../resources/assets/vendor/vaahcms/admin/default';
var admin_assets_json = JSON.parse(fs.readFileSync(input_path+'/assets.json'));

mix.setPublicPath(output_path).mergeManifest();

mix.combine(admin_assets_json['css'], output_path+'/css/vaahcms.css')
    .combine(admin_assets_json['js'], output_path+'/js/vaahcms.js')
    .js(input_path+'/vue/app-setup.js', 'builds/')
    .js(input_path+'/vue/app-login.js', 'builds/')
    .js(input_path+'/vue/app.js', 'builds/')
    .copyDirectory(input_path, resource_path, false);
