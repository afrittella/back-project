# Change Log

## [v1.0.0-beta2](https://github.com/afrittella/back-project/tree/1.0.0-beta2) (2017-03-17)

**New features**

*Changes on default Middleware*

- BackProject is provided with a custom middleware that replaces “RedirectIfAuthenticated”. If you want to use this middleware (it redirects to admin/dashboard if authenticated), you should replace the a”guest” alias in your app/Http/Middleware/Kernel.php as follows:`'guest' => \Afrittella\BackProject\Http\Middleware\RedirectIfAuthenticated::class,`
 

**Enhancements**

- Some minor changes to javascript/css assets folders. You should run again: `php artisan vendor:publish --provider="Afrittella\BackProject\BackProjectServiceProvider" --tag="public"`

- Moved default BackProject routes to [package_dir]/src/routes/web.php

- Added BackProject class and Facade for future reference.