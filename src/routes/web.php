<?php
Route::group(['namespace' => '\Afrittella\BackProject\Http\Controllers'], function () {
    Route::group(['middleware' => 'web'], function () {
        Route::get('confirm/{code}/{user}', 'Auth\RegisterController@confirm')->name('users.confirm');
        Route::auth();

        Route::get('auth/{provider}', 'Auth\SocialLoginController@redirectToProvider')->name('social_login');
        Route::get('auth/{provider}/callback', 'Auth\SocialLoginController@handleProviderCallback')->name('social_callback');
    });

    Route::group(['middleware' => 'web', 'prefix' => config('back-project.route_prefix')], function () {
        Route::get('dashboard', 'AdminController@dashboard')->name('admin.dashboard');
        Route::get('account', 'UsersController@account')->name('admin.account');
        Route::put('account', 'UsersController@accountStore')->name('admin.add-account');
        Route::post('account', 'UsersController@accountStore')->name('admin.edit-account');

        Route::get('attachments/{attachment}/delete', 'AttachmentsController@delete')->name('attachments.delete'); // Implementing delete avoiding DELETE method
        Route::get('attachments/{attachment}/main', 'AttachmentsController@setMain')->name('attachments.main');
        Route::resource('attachments', 'AttachmentsController', ['except' => ['destroy', 'show']]);
        // Users
        Route::group(['middleware' => 'role:administrator'], function () {
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