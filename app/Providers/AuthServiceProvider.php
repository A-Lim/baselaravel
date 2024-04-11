<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Passport;
use Carbon\Carbon;

use App\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\UserGroup::class => \App\Policies\UserGroupPolicy::class,
        \App\Models\Announcement::class => \App\Policies\AnnouncementPolicy::class,
        \App\Models\SystemSetting::class => \App\Policies\SystemSettingPolicy::class,
        \App\Models\Announcement::class => \App\Policies\AnnouncementPolicy::class,
        \App\Models\Customer::class => \App\Policies\CustomerPolicy::class,
        \App\Models\Package::class => \App\Policies\PackagePolicy::class,
        \App\Models\Transaction::class => \App\Policies\TransactionPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();

        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addSeconds(config('app.token.expiration')));
        Passport::personalAccessTokensExpireIn(Carbon::now()->addSeconds(config('app.token.expiration')));
        Passport::refreshTokensExpireIn(Carbon::now()->addSeconds(config('app.token.refresh_expiration')));

        if (Schema::hasTable('permissions')) {
            $permissions = Permission::permissionUserGroupsCache();

            if (!$permissions)
                return;
    
            foreach ($permissions as $permission) {
                Gate::define($permission->code, function($user) use ($permission) {
                    return $user->hasUserGroup($permission->userGroups);
                });
            }
        }
    }
}
