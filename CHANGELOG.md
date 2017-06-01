# Change Log

## 1.3.4
- ```use_custom_auth_routes``` must be ```false```
- fixed url in cached images

## 1.3.3
- 'use_custom_auth_routes' added in config.php. Now you can use your routes for login/logout/register (or simply add manually ``` Route::auth()``` in your routes)
- fixed some typos on error views. You should publish again if you published before this update.

## 1.3.2

Middleware "admin" and "role" are now not included by default in Back Project. You should insert them in Kernel.php. Then Kernel.php should look like this:

```php
...
protected $routeMiddleware = [
        ...
        'guest' => \Afrittella\BackProject\Http\Middleware\RedirectIfAuthenticated::class,        
        'admin' => \Afrittella\BackProject\Http\Middleware\Admin::class,
        'role' => \Afrittella\BackProject\Http\Middleware\Role::class,
    ];
...
```

## 1.3
This release had a massive routes refactoring, so please pay attention after updating the package.

If you copied and edited Back Project views, you should edit all routes except for login/logout/register ones provided by Laravel, adding bp before route name (example: bp.users.add).

You should edit in config/back-project.php the following line: 
```php
'redirect_after_social_login' => 'admin.dashboard',
```
becomes
```php
'redirect_after_social_login' => 'bp.admin.dashboard',
```

This is the new package/routes/web.php file:
```php
Route::group(['namespace' => '\Afrittella\BackProject\Http\Controllers'], function () {
    Route::group(['middleware' => 'web'], function () {
        Route::get('confirm/{code}/{user}', 'Auth\RegisterController@confirm')->name('bp.users.confirm');
        Route::auth();

        Route::get('auth/{provider}', 'Auth\SocialLoginController@redirectToProvider')->name('bp.social_login');
        Route::get('auth/{provider}/callback', 'Auth\SocialLoginController@handleProviderCallback')->name('bp.social_callback');
    });

    Route::group(['middleware' => 'web', 'prefix' => config('back-project.route_prefix')], function () {
        Route::get('dashboard', 'AdminController@dashboard')->name('bp.admin.dashboard');
        Route::get('account', 'UsersController@account')->name('bp.admin.account');
        Route::put('account', 'UsersController@accountStore')->name('bp.admin.add-account');
        Route::post('account', 'UsersController@accountStore')->name('bp.admin.edit-account');

        Route::get('attachments/{attachment}/delete', 'AttachmentsController@delete')->name('bp.attachments.delete'); // Implementing delete avoiding DELETE method
        Route::get('attachments/{attachment}/main', 'AttachmentsController@setMain')->name('bp.attachments.main');
        Route::resource('attachments', 'AttachmentsController', ['except' => ['destroy', 'show'], 'as' => 'bp']);
        // Users
        Route::group(['middleware' => 'role:administrator'], function () {
            Route::get('users/{user}/delete', 'UsersController@delete')->name('bp.users.delete'); // Implementing delete avoiding DELETE method
            Route::resource('users', 'UsersController', ['except' => ['destroy', 'show'], 'as' => 'bp']);

            Route::get('roles/{role}/delete', 'RolesController@delete')->name('bp.roles.delete'); // Implementing delete avoiding DELETE method
            Route::resource('roles', 'RolesController', ['except' => ['destroy', 'show'], 'as' => 'bp']);

            Route::get('permissions/{role}/delete', 'PermissionsController@delete')->name('bp.permissions.delete'); // Implementing delete avoiding DELETE method
            Route::resource('permissions', 'PermissionsController', ['except' => ['destroy', 'show'], 'as' => 'bp']);

            Route::get('menus/{menu}/up', 'MenusController@up')->name('bp.menus.up');
            Route::get('menus/{menu}/down', 'MenusController@down')->name('bp.menus.down');
            Route::get('menus/{menu}/delete', 'MenusController@delete')->name('bp.menus.delete'); // Implementing delete avoiding DELETE method
            Route::resource('menus', 'MenusController', ['except' => ['destroy', 'show'], 'as' => 'bp']);

            Route::get('media/{attachment}/delete', 'MediaController@delete')->name('bp.media.delete'); // Implementing delete avoiding DELETE method
            Route::resource('media', 'MediaController', ['except' => ['destroy', 'store', 'create', 'show'], 'as' => 'bp']);
        });
        // Main admin page
        Route::get('/', 'AdminController@redirect');
    });
});
```
Other changes
- fixed some bugs
- minor changes
  

## 1.2.1
- Minor changes and some refactoring
- Added related models view to Attachments
- Fixed an Attachment bug. Now, 'attachables' records are deleted when deleting related model 
- [README.md](https://github.com/afrittella/back-project/blob/master/README.md) updated

## 1.2
- Added findWhere and findAllBy on Repository pattern
- Some refactoring

## 1.1
- Ajax feedback when adding menu actions improved
- updated fancyBox to version 3.0.47
- updated jQuery Form Plugin to version 4.2.1
- minor changes and bug fixes

To update assets run: 
```php
php artisan vendor:publish --provider="Afrittella\BackProject\BackProjectServiceProvider" --tag="public" --force
```

## 1.0.4
- Added Services\SlugGenerator for unique slugs generation. The facade class is automatically added by BackProjectServiceProvider
- Added Traits\Sluggable for unique slugs generation on Eloquent models.
- Minor changes and bug fixes.

## 1.0.3
- Updated translations for back-project-categories package.
- Minor changes and bug fixes.

## 1.0.2
Updated README.md with new installation with composer

## 1.0.1
Updated typo in README.md

## 1.0
First official release

## V1.0.0-beta4
Added some tests.

User model now is provided by the package. You can extend it simply extending
```php
Afrittella\BackProject\Models\Auth\User;
```
## v1.0.0-beta3

**New features**

Added [laravel/socialite](https://github.com/laravel/socialite) package as new dependency. Now you can activate social login features.

*Configuration*

The package configuration file has changed. You can add new lines on your own in *config/back-project.php* or use the default configuration (*package/src/config/config.php*).

```php
<?php
return [
  'route_prefix' => 'admin',
  'registration_open' => true,
  'redirect_after_social_login' => 'admin.dashboard', // where to redirect after successfull login
  'social_login_enabled' => [
      'facebook' => true, // enable facebook login
      'twitter' => true, // enable twitter login
      'linkedin' => true // enable linkedin login
  ],
  'use_queue' => false,
  'user_model' => \App\User::class,
  // Menu logos
  'logo_large'   => '<b>Back</b>project',
  'logo_small' => '<b>B</b>p',
  'menus' => [
    'table' => 'menus'    
  ],
  'attachments' => [
      'table' => 'attachments',
      'max_file_size' => '2' // in Mb
  ]
];
```

Next, you should create [Facebook](https://developers.facebook.com/apps/), [Twitter](https://apps.twitter.com/) and [Linkedin](https://www.linkedin.com/developer/apps) applications. Once obtained app keys, add them to .env and to config/services.php as shown below.

*.env*
```apacheconfig
...
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
**Migrations**

Run

```php artisan vendor:publish --provider="Afrittella/BackProject/BackProjectServiceProvider" --tag="migrations"```

then

```php artisan migrate```

**User Model**

Change your User model as shown.

```php
...
protected $fillable = [
    'username', 'email', 'password', 'confirmation_code', 'is_social', 'confirmed'
];

// add 'social_accounts' relation [optional]
public function social_accounts()
{
    return $this->hasMany('Afrittella\BackProject\Models\SocialAccount');
}
```

That's it!

## [v1.0.0-beta2](https://github.com/afrittella/back-project/tree/1.0.0-beta2) (2017-03-17)

**New features**

*Changes on default Middleware*

- BackProject is provided with a custom middleware that replaces “RedirectIfAuthenticated”. If you want to use this middleware (it redirects to admin/dashboard if authenticated), you should replace the a”guest” alias in your app/Http/Middleware/Kernel.php as follows:`'guest' => \Afrittella\BackProject\Http\Middleware\RedirectIfAuthenticated::class,`


**Enhancements**

- Some minor changes to javascript/css assets folders. You should run again: `php artisan vendor:publish --provider="Afrittella\BackProject\BackProjectServiceProvider" --tag="public"`

- Moved default BackProject routes to [package_dir]/src/routes/web.php

- Added BackProject class and Facade for future reference.
