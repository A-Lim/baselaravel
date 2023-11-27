<?php
namespace App\Repositories;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

    public function register() {
        $this->app->bind(\App\Repositories\Auth\IOAuthRepository::class, \App\Repositories\Auth\OAuthRepository::class);
        $this->app->bind(\App\Repositories\User\IUserRepository::class, \App\Repositories\User\UserRepository::class);
        $this->app->bind(\App\Repositories\UserGroup\IUserGroupRepository::class, \App\Repositories\UserGroup\UserGroupRepository::class);
        $this->app->bind(\App\Repositories\Device\IDeviceRepository::class, \App\Repositories\Device\DeviceRepository::class);
        $this->app->bind(\App\Repositories\File\IFileRepository::class, \App\Repositories\File\FileRepository::class);
        $this->app->bind(\App\Repositories\SystemSetting\ISystemSettingRepository::class, \App\Repositories\SystemSetting\SystemSettingRepository::class);
        $this->app->bind(\App\Repositories\Permission\IPermissionRepository::class, \App\Repositories\Permission\PermissionRepository::class);
        $this->app->bind(\App\Repositories\Notification\INotificationRepository::class, \App\Repositories\Notification\NotificationRepository::class);
        $this->app->bind(\App\Repositories\Announcement\IAnnouncementRepository::class, \App\Repositories\Announcement\AnnouncementRepository::class);
        $this->app->bind(\App\Repositories\Dashboard\IDashboardRepository::class, \App\Repositories\Dashboard\DashboardRepository::class);
        $this->app->bind(\App\Repositories\ApiLog\IApiLogRepository::class, \App\Repositories\ApiLog\ApiLogRepository::class);
        $this->app->bind(\App\Repositories\Store\IStoreRepository::class, \App\Repositories\Store\StoreRepository::class);
        $this->app->bind(\App\Repositories\Client\IClientRepository::class, \App\Repositories\Client\ClientRepository::class);
        $this->app->bind(\App\Repositories\Quotation\IQuotationRepository::class, \App\Repositories\Quotation\QuotationRepository::class);
    }
}