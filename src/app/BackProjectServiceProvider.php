<?php
namespace Afrittella\BackProject;

use Afrittella\BackProject\Models\Attachment;
use Afrittella\BackProject\Models\Observers\RemoveAttachableWheDeletingAttachment;
use Afrittella\BackProject\Models\Observers\RemoveFileWhenDeletingAttachment;
use Afrittella\BackProject\Models\Observers\SaveFileWhenAddingAttachment;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Route;
use function Symfony\Component\HttpKernel\Tests\controller_func;

class BackProjectServiceProvider extends ServiceProvider
{

  protected $defer = false;

  protected $migrations = [
    'ModifyUsersTable' => 'modify_users_table',
    'CreateMenusTable' => 'create_menus_table',
    'CreateAttachmentsTable' => 'create_attachments_table'
  ];

  protected $helpers = [
    'icons'
  ];

  public function boot(\Illuminate\Routing\Router $router)
  {
    // LOAD THE VIEWS
    // - first the published views (in case they have any changes)
    $this->loadViewsFrom(resource_path('views/vendor/back-project/base'), 'back-project');
    // - then the stock views that come with the package, in case a published view might be missing
    $this->loadViewsFrom(realpath(__DIR__ . '/../resources/views'), 'back-project');

    // Load Translations
    $this->loadTranslationsFrom(realpath(__DIR__ . '/../resources/lang'), 'back-project');

    // use the vendor configuration file as fallback
    $this->mergeConfigFrom(
        __DIR__ . '/../config/config.php', 'back-project'
    );

    $this->routes($router);

    $this->publishFiles();

    $this->handleMigrations();

    $this->registerEvents();

    $this->registerCommands();

    $this->registerViewComposers();
  }

  public function register()
  {
    // register the current package
    /*$this->app->bind('back-project', function ($app) {
        return new BackProject($app);
    });*/

    $this->app->singleton('attachments-manager', function($app) {
       return new MediaManager();
    });

    // @TODO understand the use of contracts
    //$this->app->singleton(\Afrittella\BackProject\Contracts\FormBuilder::class, \Afrittella\BackProject\FormBuilder::class);
    //$this->app->singleton('form-builder', \Afrittella\BackProject\FormBuilder::class);

    // register dependencies
    $this->app->register(\Prologue\Alerts\AlertsServiceProvider::class);
    $this->app->register(\Spatie\Permission\PermissionServiceProvider::class);
    $this->app->register(\PendoNL\LaravelFontAwesome\LaravelFontAwesomeServiceProvider::class);
    $this->app->register(\Collective\Html\HtmlServiceProvider::class);
    $this->app->register(\Laravolt\Avatar\ServiceProvider::class);
    $this->app->register(\Intervention\Image\ImageServiceProvider::class);

    // register their aliases
    $loader = \Illuminate\Foundation\AliasLoader::getInstance();
    $loader->alias('Alert', \Prologue\Alerts\Facades\Alert::class);
    $loader->alias('FontAwesome', \PendoNL\LaravelFontAwesome\Facade::class);
    $loader->alias('Form', \Collective\Html\FormFacade::class);
    $loader->alias('Html', \Collective\Html\HtmlFacade::class);
    $loader->alias('Avatar', \Laravolt\Avatar\Facade::class);
    $loader->alias('MediaManager', \Afrittella\BackProject\Facades\MediaManager::class);
    $loader->alias('Image', \Intervention\Image\Facades\Image::class);

    $this->loadHelpers();

  }

  /*** Internal function ***/

  public function publishFiles()
  {
    // publish config file
    $this->publishes([__DIR__ . '/../config/config.php' => config_path().'/back-project.php'], 'config');
    // publish lang files
    $this->publishes([__DIR__ . '/../resources/lang' => resource_path('lang/vendor/back-project')], 'lang');
    // publish public Backpack assets
    $this->publishes([__DIR__ . '/../public' => public_path('vendor/back-project')], 'public');
    // publish views
    $this->publishes([__DIR__ . '/../resources/views' => resource_path('views/vendor/back-project')], 'views');
    // publish error views
    $this->publishes([__DIR__ . '/../resources/error_views' => resource_path('views/errors')], 'errors');
    // publish public AdminLTE assets
    $this->publishes(['vendor/almasaeed2010/adminlte/bootstrap' => public_path('vendor/adminlte/bootstrap')], 'adminlte');
    $this->publishes(['vendor/almasaeed2010/adminlte/dist' => public_path('vendor/adminlte/dist')], 'adminlte');
    $this->publishes(['vendor/almasaeed2010/adminlte/plugins' => public_path('vendor/adminlte/plugins')], 'adminlte');
  }

  public function routes(Router $router)
  {
    // Register Middleware

    $router->aliasMiddleware('admin', \Afrittella\BackProject\Http\Middleware\Admin::class);
    $router->aliasMiddleware('guest', \Afrittella\BackProject\Http\Middleware\RedirectIfAuthenticated::class);
    $router->aliasMiddleware('role', \Afrittella\BackProject\Http\Middleware\Role::class);

    $router->group(['namespace' => 'Afrittella\BackProject\Http\Controllers'], function($router) {
        Route::group(['middleware' => 'web'], function() {
            Route::get('confirm/{code}/{user}', 'Auth\RegisterController@confirm')->name('users.confirm');
            Route::auth();
        });

        Route::group(['middleware' => 'web', 'prefix' => config('back-project.route_prefix')], function() {
            Route::get('dashboard', 'AdminController@dashboard')->name('admin.dashboard');

            Route::get('attachments/{attachment}/delete', 'AttachmentsController@delete')->name('attachments.delete'); // Implementing delete avoiding DELETE method
            Route::get('attachments/{attachment}/main', 'AttachmentsController@setMain')->name('attachments.main');
            Route::resource('attachments', 'AttachmentsController', ['except' => ['destroy', 'show']]);
            // Users
            Route::group(['middleware' => 'role:administrator'], function() {
                Route::get('users/{user}/delete', 'UsersController@delete')->name('users.delete'); // Implementing delete avoiding DELETE method
                Route::resource('users', 'UsersController', ['except' => ['destroy', 'show']]);

                Route::get('roles/{role}/delete', 'RolesController@delete')->name('roles.delete'); // Implementing delete avoiding DELETE method
                Route::resource('roles', 'RolesController', ['except' => ['destroy', 'show']]);

                Route::get('permissions/{role}/delete', 'PermissionsController@delete')->name('permissions.delete'); // Implementing delete avoiding DELETE method
                Route::resource('permissions', 'PermissionsController', ['except' => ['destroy', 'show']]);

                Route::get('menus/{menu}/up', 'MenusController@up')->name('menus.up');
                Route::get('menus/{menu}/down', 'MenusController@down')->name('menus.down');
                Route::get('menus/{menu}/delete', 'MenusController@delete')->name('menus.delete'); // Implementing delete avoiding DELETE method
                Route::resource('menus', 'MenusController', ['except' => ['destroy', 'show']]);

                Route::get('media/{attachment}/delete', 'MediaController@delete')->name('media.delete'); // Implementing delete avoiding DELETE method
                Route::resource('media', 'MediaController', ['except' => ['destroy', 'store', 'create', 'show']]);
            });
            // Main admin page
            Route::get('/', 'AdminController@redirect');
        });

    });
  }

  public function handleMigrations()
  {
    foreach ( $this->migrations as $class => $file ) {
      if ( ! class_exists($class) ) {
        $timestamp = date('Y_m_d_His', time());

        $this->publishes([
            __DIR__ . '/../database/migrations/' . $file .'.php' =>
                database_path('migrations/'. $timestamp .'_'. $file .'.php')
        ], 'migrations');
      }
    }
  }

  public function registerEvents()
  {
      // User notification can use queues or not
      if (config('back-project.use_queue')) {
          \Event::listen('Afrittella\BackProject\Events\UserRegistered', 'Afrittella\BackProject\Listeners\SendRegistrationEmail');
      } else {
          \Event::listen('Afrittella\BackProject\Events\UserRegistered', 'Afrittella\BackProject\Listeners\SendRegistrationEmailNoQueue');
      }

      // Register Observers
      Attachment::observe(SaveFileWhenAddingAttachment::class);
      Attachment::observe(RemoveFileWhenDeletingAttachment::class);
      Attachment::observe(RemoveAttachableWheDeletingAttachment::class);
  }

  public function registerCommands()
  {
    if ($this->app->runningInConsole()) {
        $this->commands([
            \Afrittella\BackProject\Console\Commands\SeedDefaultMenus::class,
            \Afrittella\BackProject\Console\Commands\SeedPermissions::class
        ]);
    }
  }

  public function registerViewComposers()
  {
    \View::composer(['back-project::layouts.admin'], 'Afrittella\BackProject\Http\ViewComposers\AdminMenuComposer');
    \View::composer(['back-project::layouts.admin'], 'Afrittella\BackProject\Http\ViewComposers\UserComposer');
  }

  public function loadHelpers()
  {
      foreach ($this->helpers as $helper):
          $file = __DIR__ . '/Helpers/' . $helper . '.php';

          if(file_exists($file)) {
              require_once($file);
          }
      endforeach;
  }

}
