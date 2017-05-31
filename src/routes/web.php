<?php
Route::group(['namespace' => '\Afrittella\BackProject\Http\Controllers'], function () {
    Route::group(['middleware' => 'web'], function () {
        Route::get('confirm/{code}/{user}', 'Auth\RegisterController@confirm')->name('bp.users.confirm');

        if (empty(config('back-project.use_custom_auth_routes'))) {
            Route::auth();
        }

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