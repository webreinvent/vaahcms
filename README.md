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
'providers' => [
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
var admin_path = 'packages/vaahcms/src/Resources/assets/admin/';
var admin_default_theme_path = admin_path+'default/';
var desc_admin_default_theme_path = 'resources/assets/vendor/vaahcms/admin/default/';

var admin_assets_json = JSON.parse(fs.readFileSync(admin_default_theme_path+'assets.json'));

mix.setPublicPath(desc_admin_default_theme_path);

mix.combine(admin_assets_json['css'], desc_admin_default_theme_path+'builds/vaahcms.css')
    .combine(admin_assets_json['js'], desc_admin_default_theme_path+'builds/vaahcms.js')
    .js(admin_default_theme_path+'vue/app-dashboard.js',  './builds')
    .js(admin_default_theme_path+'vue/app-modules.js',  './builds')
    .copyDirectory(admin_path, './resources/assets/vendor/vaahcms/admin/', false)
    .version();


mix.webpackConfig({
    watchOptions: {
        aggregateTimeout: 2000,
        poll: 20,
        ignored: [
            '/app/',
            '/bootstrap/',
            '/config/',
            '/database/',
            '/packages/',
            '/public/',
            '/routes/',
            '/storage/',
            '/tests/',
            '/vaahcms/',
            '/node_modules/',
            '/vendor/',

        ]
    }
});


```


## Tools

- https://www.mkdocs.org - for docs 

## Tutorials
### Update Packagist with GitHub Webhooks

- As the PayLoad URL type in:
Visit: `https://packagist.org/profile/` and get the `API Token` and 
```
https://packagist.org/api/github?username=PACKAGIST_USERNAME
```

- Go to your GitHub repository and select  Settings -> WebHooks -> Add Webhook
- In `Payload URL` enter the packagist url
- In `Content type` choose `application/json`
- In `Secrete` add `API Token`
- Choose `Let me select individual events.` and select `Pushes`
- Click on `Save`

### New Release

- composer.json version should match with your release via github then only it will be updated on `packagist` 