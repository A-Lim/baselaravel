<?php

Route::prefix('v1')->group(function () {

    /**** Auth ****/
    Route::namespace('API\v1\Auth')->group(function () {
        Route::post('login', 'LoginController@login');
        Route::post('login/facebook', 'LoginController@facebookLogin');
        Route::post('logout', 'LoginController@logout');
        // Route::post('token/refresh', 'LoginController@refresh');
        Route::post('register', 'RegistrationController@register');
        Route::post('forgot-password', 'ForgotPasswordController@sendResetLink');
        Route::post('reset-password', 'ForgotPasswordController@resetPassword');

        Route::get('verify-email', 'VerificationController@verifyEmail')->name('verification.verify');
        Route::post('verify-email', 'VerificationController@sendVerificationEmail');
    });

    /**** Device ****/
    Route::namespace('API\v1\Device')->group(function () {
        Route::patch('devices', 'DeviceController@update');
    });

    // Route::middleware(['apilogger'])->group(function () {
        /**** User ****/
        Route::namespace('API\v1\User')->group(function () {
            Route::get('users', 'UserController@list');
            Route::get('users/{user}', 'UserController@details');
            Route::get('profile', 'UserController@profile');
            Route::post('users/{user}/reset-password', 'UserController@resetPassword');
            Route::patch('profile', 'UserController@updateProfile');
            Route::patch('profile/default-store', 'UserController@updateDefaultStore');
            Route::patch('users/{user}', 'UserController@update');

            Route::patch('users/{user}/avatar', 'UserController@uploadUserAvatar');
            Route::patch('profile/avatar', 'UserController@uploadProfileAvatar');
        });

        /**** UserGroup ****/
        Route::namespace('API\v1\UserGroup')->group(function () {
            
            Route::get('usergroups', 'UserGroupController@list');
            Route::get('usergroups/{userGroup}', 'UserGroupController@details');
            Route::get('usergroups/{userGroup}/users', 'UserGroupController@listUsers');
            Route::get('usergroups/{userGroup}/notusers', 'UserGroupController@listNotUsers');

            Route::post('usergroups', 'UserGroupController@create');
            Route::post('usergroups/exists', 'UserGroupController@exists');
            Route::post('usergroups/{userGroup}/users', 'UserGroupController@addUsers');
            
            Route::patch('usergroups/{userGroup}', 'UserGroupController@update');
            Route::delete('usergroups/{userGroup}', 'UserGroupController@delete');
            Route::delete('usergroups/{userGroup}/users/{user}', 'UserGroupController@removeUser');
        });

        /**** Files ****/
        Route::namespace('API\v1\File')->group(function () {
            Route::post('files/upload', 'FileController@upload');
            Route::delete('files/{file}', 'FileController@delete');
        });

        /**** SystemSettings ****/
        Route::namespace('API\v1\SystemSetting')->group(function () {
            Route::get('systemsettings', 'SystemSettingController@list');
            Route::get('systemsettings/allowpublicregistration', 'SystemSettingController@allowPublicRegistration');
            Route::patch('systemsettings', 'SystemSettingController@update');
        });

        /**** Permissions ****/
        Route::namespace('API\v1\Permission')->group(function () {
            Route::get('permissions', 'PermissionController@list');
            Route::get('permissions/my', 'PermissionController@myPermissions');
        });

        /**** Notifications ****/
        Route::namespace('API\v1\Notification')->group(function () {
            Route::get('notifications', 'NotificationController@list');
            Route::get('notifications/unreadcount', 'NotificationController@unreadCount');
            Route::post('notifications/all/read', 'NotificationController@readAll');
            Route::post('notifications/{notification}/read', 'NotificationController@read');
            Route::delete('notifications/{notification}', 'NotificationController@delete');
        });

        /**** Announcements ****/
        Route::namespace('API\v1\Announcement')->group(function () {
            Route::get('announcements', 'AnnouncementController@list');
            Route::get('announcements/my', 'AnnouncementController@listMy');
            Route::get('announcements/{announcement}', 'AnnouncementController@details');
            Route::post('announcements', 'AnnouncementController@create');
            Route::patch('announcements/{announcement}', 'AnnouncementController@update');
            Route::delete('announcements/{announcement}', 'AnnouncementController@delete');
        });

        /**** Dashboards ****/
        Route::namespace('API\v1\Dashboard')->group(function () {
            Route::get('widget-types', 'DashboardController@listWidgetTypes');

            Route::get('dashboards', 'DashboardController@list');
            Route::get('dashboards/{dashboard}/data', 'DashboardController@data');
            Route::post('dashboards', 'DashboardController@create');
            Route::patch('dashboards/{dashboard}', 'DashboardController@update');
        });

        /**** Stores ****/
        Route::namespace('API\v1\Store')->group(function () {
            Route::get('stores', 'StoreController@list');
            Route::post('stores', 'StoreController@create');
            Route::patch('stores/{store}', 'StoreController@update');
        });

    // });
});
