[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/afrittella/back-project/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/afrittella/back-project/?branch=master)
[![StyleCI](https://styleci.io/repos/84803631/shield?branch=master)](https://styleci.io/repos/84803631)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://travis-ci.org/afrittella/back-project.svg?branch=master)](https://travis-ci.org/afrittella/back-project)

# Back Project 1.0 (1.0.3)
Back Project is an admin panel for Laravel 5.4+ based on [AdminLTE](https://github.com/almasaeed2010/AdminLTE) and other amazing packages. See [Credits](#credits) for details.

### Features
- AdminLTE template
- Easy to use Html components and helpers for panels, buttons, links, icons
- Simple authorization management built on top of [spatie/laravel-permission](https://github.com/spatie/laravel-permission)
- Menu management
- Media Manager: you can upload media as backend user or manage all media uploaded by other users as administrator (see [Media Manager](#media-manager))
- Social Login

### Installation
```
composer require afrittella/back-project
```

Add the Service Provider to your config.app service providers list:
```php
Afrittella\BackProject\BackProjectServiceProvider::class,

```

**Publishing configuration, assets, view, migrations**

***Configuration***

```
php artisan vendor:publish --provider="Afrittella\BackProject\BackProjectServiceProvider" --tag="config"

php artisan vendor:publish --provider="Prologue\Alerts\AlertsServiceProvider"

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="config"

php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravel5"

```
In config/laravel-permission.php change model classes to:
```php
'permission' => Afrittella\BackProject\Models\Permission::class,
'role' => Afrittella\BackProject\Models\Role::class,
```

Social login is disabled by default. To use it you must follow these steps:

- Change the following lines in config/back-project.php

  ```php
  'social_login_enabled' => [
    'facebook' => true, // enable facebook login
    'twitter' => true, // enable twitter login
    'linkedin' => true // enable linkedin login
  ],
  ```
- Create [Facebook](https://developers.facebook.com/apps/), [Twitter](https://apps.twitter.com/) and [Linkedin](https://www.linkedin.com/developer/apps) applications.
- Once obtained app keys, add them to .env and to config/services.php as shown below.

    *.env*

    ```apacheconfig
    FACEBOOK_ID = XXXXXXXX
    FACEBOOK_SECRET = XXXXX
    FACEBOOK_REDIRECT = http://example.com/auth/facebook/callback

    TWITTER_ID = XXXXXXXX
    TWITTER_SECRET = XXXXX
    TWITTER_REDIRECT = http://example.com/auth/twitter/callback

    LINKEDIN_ID = XXXXXXXX
    LINKEDIN_SECRET = XXXXX
    LINKEDIN_REDIRECT = http://example.com/auth/linkedin/callback
    ```

    *config/service.php*

    ```php
    ...
    'facebook' => [
        'client_id' => env('FACEBOOK_ID'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT'),
    ],

    'twitter' => [
        'client_id' => env('TWITTER_ID'),
        'client_secret' => env('TWITTER_SECRET'),
        'redirect' => env('TWITTER_REDIRECT'),
    ],

    'linkedin' => [
        'client_id' => env('LINKEDIN_ID'),
        'client_secret' => env('LINKEDIN_SECRET'),
        'redirect' => env('LINKEDIN_REDIRECT'),
    ]
    ```

**Language**

*At this time only italian and english language are supported.*

Run

```
php artisan vendor:publish --provider="Afrittella\BackProject\BackProjectServiceProvider" --tag="lang"
```

Please note: *You don't need to publish translation files if you don't want to change default strings.*

Default Laravel languages are provided by [caousecs/laravel-lang](https://github.com/caouecs/Laravel-lang) package. You had to manually copy translation files based on the language you will use on your project.

Copy the content of vendor/caouecs/laravel-lang/src/[language-folder] to resources/lang/[language-folder]

**BackProject, AdminLTE, Avatar assets and views**
```
php artisan vendor:publish --provider="Afrittella\BackProject\BackProjectServiceProvider" --tag="adminlte"

php artisan vendor:publish --provider="Laravolt\Avatar\ServiceProvider"

php artisan vendor:publish --provider="Afrittella\BackProject\BackProjectServiceProvider" --tag="public"

php artisan vendor:publish --provider="Afrittella\BackProject\BackProjectServiceProvider" --tag="errors"
```

You can publish Back Project default views if you want to edit them:
```
php artisan vendor:publish --provider="Afrittella\BackProject\BackProjectServiceProvider" --tag="views"
```

**Migrations**
```
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
```

Run

```
php artisan migrate

php artisan back-project:seed-permissions

php artisan back-project:seed-menus
```

### Configuration
**Queue**

Queues can be used to send registration email.

To set up queues:
- Change .env file. Set `QUEUE_DRIVER=database`
- Change config/back-project.php line: ``"use_queue" => true,``
- Run ``` php artisan queue:table``` to create the jobs table
- Run ``` php artisan queue:failed-table```
- Config queue worker as described on [Laravel documentation](https://laravel.com/docs/5.4/queues#running-the-queue-worker)

By default Back Project use classic notification system.

**Authorization**

BackProject is provided with a custom middleware that replaces “RedirectIfAuthenticated”. If you want to use this middleware (it redirects to admin/dashboard if authenticated), you should replace the ”guest” alias in your app/Http/Middleware/Kernel.php as follows:
```
'guest' => \Afrittella\BackProject\Http\Middleware\RedirectIfAuthenticated::class,
```

*User model*

A default *User* model is provided with the package. It has all the features to make Back Project works well. If you would like to use your custom model, simply extend:
```php
Afrittella\BackProject\Models\Auth\User;
```

If you are using package model, or if your *User* model is not present in the default folder, you must change config/auth.php:
```php
...
'providers' => [
  'users' => [
      'driver' => 'eloquent',
      'model' => Afrittella\BackProject\Models\Auth\User::class,
  ],
  ...
```

Remember to change *user_model* key in config/back-project.php if you want to use your custom *User* model.

*Back Project simple auth method*

Back Project has a simple authorization method, located in Afrittella/BackProject/Http/Controllers/Controller.php

```php
public function bCAuthorize($ability, $record = [])
{
     if ($record->user_id !== Auth::user()->id) {
         abort(403);
     }
}
```

You can use it if you want to simply check if a user is authorized to manage a record. Just use this controller instead of Laravel default controller and call “bCAuthorize” before doing any database action

**Exceptions**

Back Project has a default exception handler who renders custom error views. To use this handler add the following lines to Exceptions/Handler.php
```php
...
use Afrittella\BackProject\Exceptions\BackProjectHandler;
use Afrittella\BackProject\Exceptions\BaseException;

class Handler extends ExceptionHandler
{
    ...

    public function render($request, Exception $exception)
    {
        ...

        if ($exception instanceof BaseException) {
            if ($response = BackProjectHandler::getResponse($exception)) {
                return $response;
            }
        }

        ...

        return parent::render($request, $exception);
    }
}
```

### Let's Start
Once completed the [Installation](#installation) and [Configuration](#configuration) sections, go to your project's url (www.example.com/register), register and activate the first user who will be the site administrator.

### Media Manager

Back Project use intervention/image and intervention/imagecache to manage image upload, resizing and display. Once uploaded, an image can be displayed using imagecache package and default or custom filters. Feel free to create custom filters for your images.

Change config/imagecache.php following this example:
```php
return array(

    /*
    |--------------------------------------------------------------------------
    | Name of route
    |--------------------------------------------------------------------------
    |
    | Enter the routes name to enable dynamic imagecache manipulation.
    | This handle will define the first part of the URI:
    |
    | {route}/{template}/{filename}
    |
    | Examples: "images", "img/cache"
    |
    */

    'route' => [FIRST PART OF THE URI YOU WANT FOR DISPLAYING IMAGES],

    /*
    |--------------------------------------------------------------------------
    | Storage paths
    |--------------------------------------------------------------------------
    |
    | The following paths will be searched for the image filename, submited
    | by URI.
    |
    | Define as many directories as you like.
    |
    */

    'paths' => array(
	// Insert here your uploads directory
        public_path('upload'),
        public_path('images')        
    ),

    /*
        |--------------------------------------------------------------------------
        | Manipulation templates
        |--------------------------------------------------------------------------
        |
        | Here you may specify your own manipulation filter templates.
        | The keys of this array will define which templates
        | are available in the URI:
        |
        | {route}/{template}/{filename}
        |
        | The values of this array will define which filter class
        | will be applied, by its fully qualified name.
        |
        */

        'templates' => array(
            'small' => 'Intervention\Image\Templates\Small',
            'medium' => 'Intervention\Image\Templates\Medium',
            'large' => 'Intervention\Image\Templates\Large',
        ),

        /*
        |--------------------------------------------------------------------------
        | Image Cache Lifetime
        |--------------------------------------------------------------------------
        |
        | Lifetime in minutes of the images handled by the imagecache route.
        |
        */

        'lifetime' => 43200,

    );

```

Read the Intervention/Image [documentation](http://image.intervention.io/getting_started/installation#laravel) to know how to use it.

You can use *HasOneAttachment* or *HasManyAttachment* trait on a model to associate it to *attachments* table.

Example:
```php
...
use Afrittella\BackProject\Traits\HasOneAttachment;
...

class Model
{
    use HasOneAttachment;

    ...
}
```
You can change the folder where files are uploaded in config/filesystems.php

### ToDo
- Full documentation on wiki.
- More Tests.
- Better assets (js/css) management.
- Better translations management.

### Credits

I was inspired by [Backpack for Laravel](https://github.com/Laravel-Backpack) project, but i tried to make a simple one with only the features I need for my projects. Feel free to open a PR or send a feedback if you would like to collaborate and improve it.

Back Project depends on the following packages:

- [almasaeed2010/adminlte](https://github.com/almasaeed2010/AdminLTE)
- [prologue/alerts](https://github.com/prologuephp/alerts)
- [doctrine/dbal](https://github.com/doctrine/dbal)
- [spatie/laravel-permission](https://github.com/spatie/laravel-permission)
- [kalnoy/nestedset](https://github.com/lazychaser/laravel-nestedset)
- [pendonl/laravel-fontawesome](https://github.com/PendoNL/laravel-fontawesome)
- [laravelcollective/html](https://github.com/LaravelCollective/html)
- [caouecs/laravel-lang](https://github.com/caouecs/Laravel-lang)
- [intervention/image](https://github.com/Intervention/image)
- [intervention/imagecache](https://github.com/Intervention/imagecache)
- [laravel/socialite](https://github.com/laravel/socialite)

 ### License

 This package is licensed under the [MIT license](https://github.com/backup-manager/laravel/blob/master/LICENSE).
