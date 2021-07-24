<?php
namespace App\Repositories;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

    public function register() {
        $this->app->bind('App\Repositories\Auth\IOAuthRepository', \App\Repositories\Auth\OAuthRepository::class);
        $this->app->bind('App\Repositories\User\IUserRepository', \App\Repositories\User\UserRepository::class);
        $this->app->bind('App\Repositories\UserGroup\IUserGroupRepository', \App\Repositories\UserGroup\UserGroupRepository::class);
        $this->app->bind('App\Repositories\Device\IDeviceRepository', \App\Repositories\Device\DeviceRepository::class);
        $this->app->bind('App\Repositories\File\IFileRepository', \App\Repositories\File\FileRepository::class);
        $this->app->bind('App\Repositories\SystemSetting\ISystemSettingRepository', \App\Repositories\SystemSetting\SystemSettingRepository::class);
        $this->app->bind('App\Repositories\Permission\IPermissionRepository', \App\Repositories\Permission\PermissionRepository::class);
        $this->app->bind('App\Repositories\Notification\INotificationRepository', \App\Repositories\Notification\NotificationRepository::class);
        $this->app->bind('App\Repositories\Announcement\IAnnouncementRepository', \App\Repositories\Announcement\AnnouncementRepository::class);
        $this->app->bind('App\Repositories\ApiLog\IApiLogRepository', \App\Repositories\ApiLog\ApiLogRepository::class);
        
    }
}