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

#### Publish Seeds
```bash
php artisan vendor:publish --provider="WebReinvent\VaahCms\VaahCmsServiceProvider" --tag=seeds
```

#### Publish Assets
```bash
php artisan vendor:publish --provider="WebReinvent\VaahCms\VaahCmsServiceProvider" --tag=assets
```



#### Create migrations
```bash
php artisan make:migration create_vh_users_table --path=/packages/vaahcms/src/Database/Migrations
```

#### Create seeds
```bash
php artisan make:seeder PermissionsTableSeeder --path=/packages/vaahcms/src/Database/Seeders
php artisan make:seeder RolesTableSeeder --path=/packages/vaahcms/src/Database/Seeders
php artisan make:command HealthcheckCommand --path=/packages/vaahcms/src/Database/Seeders
```

## Steps to Setup

### Step 1) Install Package
```bash
composer require webreinvent/vaahcms
```

### Step 2) Publish Assets
```bash
php artisan vendor:publish --provider="WebReinvent\VaahCms\VaahCmsServiceProvider" --tag=assets
php artisan vendor:publish --provider="WebReinvent\VaahCms\VaahCmsServiceProvider" --tag=migrations
php artisan vendor:publish --provider="WebReinvent\VaahCms\VaahCmsServiceProvider" --tag=seeds
```

### Step 3) Register Service Provider

Add following service provider in `config/app.php`

```php
/*
 * Package Service Providers...
 */
WebReinvent\VaahCms\VaahCmsServiceProvider::class,
```

### Step 4) 
```php
'guards' => [
        //...
        'users' => [
            'driver' => 'eloquent',
            'model' => \WebReinvent\VaahCms\Entities\User::class,
        ],
        //...
    ],
```

### Step 5) Update composer.json file

Create following folder in your laravel root folder

```
vaahcms/Modules
vaahcms/Plugins
```

Add following two lines in `psr-4` in `composer.json`
```json
...
"autoload": {
    "files": [],
    "psr-4": {
        "App\\": "app/",
        ...
        "VaahCms\\Modules\\": "vaahcms/Modules/",
        "VaahCms\\Plugins\\": "vaahcms/Plugins/"
        ...
    },
    "classmap": [
        "database/seeds",
        "database/factories"
    ]
},
...
```

Then run following command
```bash
composer dump-autoload
```

## Minify Assets of Admin with Laravel Mix

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