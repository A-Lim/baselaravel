<?php
namespace App\Repositories;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

    public function register() {
        $this->app->bind('App\Repositories\Auth\IOAuthRepository', 'App\Repositories\Auth\OAuthRepository');
        $this->app->bind('App\Repositories\User\IUserRepository', 'App\Repositories\User\UserRepository');
        $this->app->bind('App\Repositories\UserGroup\IUserGroupRepository', 'App\Repositories\UserGroup\UserGroupRepository');
        $this->app->bind('App\Repositories\Device\IDeviceRepository', 'App\Repositories\Device\DeviceRepository');
        $this->app->bind('App\Repositories\File\IFileRepository', 'App\Repositories\File\FileRepository');
        $this->app->bind('App\Repositories\SystemSetting\ISystemSettingRepository', 'App\Repositories\SystemSetting\SystemSettingRepository');
        $this->app->bind('App\Repositories\Permission\IPermissionRepository', 'App\Repositories\Permission\PermissionRepository');
        $this->app->bind('App\Repositories\Notification\INotificationRepository', 'App\Repositories\Notification\NotificationRepository');
        $this->app->bind('App\Repositories\Announcement\IAnnouncementRepository', 'App\Repositories\Announcement\AnnouncementRepository');
        $this->app->bind('App\Repositories\ApiLog\IApiLogRepository', 'App\Repositories\ApiLog\ApiLogRepository');
        
    }
}