const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');
var fs = require('fs');
const fs_extra = require('fs-extra');

let input_path = __dirname+'/src/Resources/assets/admin/default';
let output_path = '../../resources/assets/vendor/vaahcms/admin/default';
var admin_assets_json = JSON.parse(fs.readFileSync(input_path+'/assets.json'));

mix.setPublicPath(output_path).mergeManifest();

mix.copyDirectory(input_path+'/css', output_path+'/css/', false)
    .combine(admin_assets_json['css'], output_path+'/builds/vaahcms.css')
    .combine(admin_assets_json['js'], output_path+'/builds/vaahcms.js')
    .js(input_path+'/vue/app.js', 'builds/')
    .js(input_path+'/vue/app-login.js', 'builds/');

