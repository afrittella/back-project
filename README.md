# Back Project
Back Project is an admin panel for Laravel 5.4 based on [AdminLTE](https://github.com/almasaeed2010/AdminLTE) and other amazing packages. See [Credits](#credits) for details.

### Features
- AdminLTE template
- Easy to use Html components and helpers for panels, buttons, links, icons
- Simple authorization management built on top of [spatie/laravel-permission](https://github.com/spatie/laravel-permission)
- Menu management
- Media Manager: you can upload media as backend user or manage all media uploaded by other users as administrator (see [MediaManager](#media-manager))

### Installation
This package is still in beta version, so if you want to try it, you had to insert some code in your composer.json

```json
"repositories": [         
         {
          "type": "vcs",
          "url": "https://github.com/afrittella/back-project"
         }
     ],
     "minimum-stability": "dev",
     "prefer-stable": true
```

Run
```
composer require afrittella/back-project
```

Add the Service Provider to your config.app service providers list:
```
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
php artisan vendor:publish --provider="Afrittella\BackProject\BackProjectServiceProvider" --tag="migrations"

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

Add the following traits to you *User* model and write/change some code.
```php
...
use Afrittella\BackProject\Traits\UserConfirmation // manage 2 steps user registration
use Spatie\Permission\Traits\HasRoles // enable permission management
...

class User extends Authenticatable
{
    use ..., HasRoles, UserConfirmation;
    
    protected $fillable = [
        'username', 'email', 'password', 'confirmation_code'
    ];
    
    ...
    
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
     public function sendPasswordResetNotification($token)
     {
       $this->notify(new Afrittella\BackProject\Notifications\ResetPassword($token));
     }
}
```

If your *User* model is not present in the default folder, you must change the ```"user_model"``` key in config/back-project.php, and, of course in auth/config.php :)

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

### Usage
Once completed the [Installation](#installation) and [Configuration](#configuration) sections, go to your project's url (www.example.com/register), register and activate the first user who will be the site administrator.

**Media Manager**

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


### Credits
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

I was inspired by [Backpack for Laravel](https://github.com/Laravel-Backpack) project, but i tried to make a simple package with only the features I need for my projects. Feel free to contact me if you'd like to collaborate and improve it.
 
 ### License
 
 This package is licensed under the [MIT license](https://github.com/backup-manager/laravel/blob/master/LICENSE).