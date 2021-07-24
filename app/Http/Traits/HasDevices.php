<?php
namespace App\Http\Traits;

use App\Models\Device;

trait HasDevices {
    public function devices() {
        return $this->hasMany(Device::class);
    }
}
