# vaahcms
Laravel Based Rapid Development CMS

### Commands

#### Publish All Assets
```bash
php artisan vendor:publish --provider="WebReinvent\VaahCms\VaahCmsServiceProvider"
```

#### Publish All Configuration
```bash
php artisan vendor:publish --provider="WebReinvent\VaahCms\VaahCmsServiceProvider" --tag=config
```

#### Publish Languages
```bash
php artisan vendor:publish --provider="WebReinvent\VaahCms\VaahCmsServiceProvider" --tag=lang
```

#### Publish Views
```bash
php artisan vendor:publish --provider="WebReinvent\VaahCms\VaahCmsServiceProvider" --tag=views
```

#### Publish Migrations
```bash
php artisan vendor:publish --provider="WebReinvent\VaahCms\VaahCmsServiceProvider" --tag=migrations
```

#### Publish Assets
```bash
php artisan vendor:publish --provider="WebReinvent\VaahCms\VaahCmsServiceProvider" --tag=assets
```

#### Create migrations
```bash
php artisan make:migration create_vh_users_table --path=/packages/vaahcms/src/Database/Migrations
```

### Step 1) Publish Assets
```bash
php artisan vendor:publish --provider="WebReinvent\VaahCms\VaahCmsServiceProvider" --tag=assets
```

### Step 2) Minify Assets with Laravel Mix

Install following package
```bash
npm install --save-dev fs
```

Replace the content of `webpack.mix.fs`
```bash
const mix = require('laravel-mix');
var fs = require('fs');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

var admin_assets_json = JSON.parse(fs.readFileSync('resources/assets/vendor/vaahcms/admin/default/assets.json'));

console.log(admin_assets_json);

mix.combine(admin_assets_json['css'], 'public/css/vaahcms-admin.css')
    .combine(admin_assets_json['js'], 'public/js/vaahcms-admin.js')
    .version();

```