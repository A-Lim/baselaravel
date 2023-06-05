<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Redactors\LeftRedactor;

use Laravel\Passport\HasApiTokens;
use App\Notifications\CustomResetPassword;
use App\Notifications\CustomVerifyEmail;
use App\Http\Traits\HasUserGroups;
use App\Http\Traits\HasDevices;
use App\Http\Traits\CustomQuery;

class User extends Authenticatable implements Auditable {
    use Notifiable, HasApiTokens, HasUserGroups, HasDevices, CustomQuery, \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'email', 'gender', 'date_of_birth', 'phone', 'password', 'email_verified_at', 'status'];
    protected $hidden = ['password', 'remember_token', 'created_at', 'updated_at'];
    protected $casts = [];

    protected $attributeModifiers = [
        'password' => LeftRedactor::class,
    ];

    // list of properties queryable for datatable
    public static $queryable = ['name', 'email', 'phone', 'date_of_birth', 'gender', 'status'];

    const STATUS_ACTIVE = 'active';
    const STATUS_LOCKED = 'locked';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_UNVERIFIED = 'unverified';

    const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_LOCKED,
        self::STATUS_UNVERIFIED,
        self::STATUS_INACTIVE,
    ];

    public function avatar() {
        return $this->morphOne(File::class, 'fileable');
    }

    /**
     * Model events
     *
     * @return void
     */
    public static function boot() {
        parent::boot();

        self::creating(function($model) {
            // if status is not provided
            // set default to unverified
            if (empty($model->status)) {
                $model->status = self::STATUS_UNVERIFIED;
            }
        });
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new CustomResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification() {
        $this->notify(new CustomVerifyEmail($this->email));
    }

    /**
     * Mark email as verified (email_verified_at, status)
     *
     * @return void
     */
    public function markEmailAsVerified() {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
            'status' => self::STATUS_ACTIVE,
        ])->save();
    }

    /**
     * Checks if user is verified
     *
     * @return boolean
     */
    public function hasVerifiedEmail() {
        return $this->status != self::STATUS_UNVERIFIED || $this->email_verified_at != null;
    }

    /******** Accessors and Mutators ********/
}
