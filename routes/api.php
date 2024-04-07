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

    Route::middleware(['apilogger'])->group(function () {
        /**** User ****/
        Route::namespace('API\v1\User')->group(function () {
            Route::get('users', 'UserController@list');
            Route::get('users/{user}', 'UserController@details');
            Route::get('profile', 'UserController@profile');
            Route::post('users/{user}/reset-password', 'UserController@resetPassword');
            Route::patch('profile', 'UserController@updateProfile');
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

        /**** Customers ****/
        Route::namespace('API\v1\Customer')->group(function () {
            Route::get('customers', 'CustomerController@list');
            Route::get('customers/{customer}', 'CustomerController@details');
            Route::post('customers', 'CustomerController@create');
            Route::post('customers/bulk', 'CustomerController@bulkCreate');
            Route::patch('customers/{customer}', 'CustomerController@update');
            Route::delete('customers/{customer}', 'CustomerController@delete');

            Route::get('customers/{customer}/packages', 'CustomerController@packages');
            Route::post('customers/{customer}/packages/purchase', 'CustomerController@purchasePackage');
            Route::post('customers/{customer}/packages/bulk-purchase', 'CustomerController@bulkPurchasePackage');

            Route::get('customers/{customer}/transactions', 'CustomerController@transactions');
        });

        /**** Packages ****/
        Route::namespace('API\v1\Package')->group(function () {
            Route::get('packages', 'PackageController@list');
            Route::get('packages/all', 'PackageController@listAll');
            Route::get('packages/{package}', 'PackageController@details');
            Route::post('packages', 'PackageController@create');
            Route::post('packages/bulk', 'PackageController@bulkCreate');
            Route::patch('packages/{package}', 'PackageController@update');
            Route::delete('packages/{package}', 'PackageController@delete');
        });

        /**** Packages ****/
        Route::namespace('API\v1\Transaction')->group(function () {
            // Route::get('transactions', 'TransactionController@list');
            // Route::get('transactions/{transaction}', 'TransactionController@details');
            Route::post('transactions', 'TransactionController@create');
            // Route::patch('transactions/{transaction}', 'TransactionController@update');
            // Route::delete('transactions/{transaction}', 'TransactionController@delete');
        });
    });
});
