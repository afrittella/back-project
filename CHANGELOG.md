# Change Log

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
