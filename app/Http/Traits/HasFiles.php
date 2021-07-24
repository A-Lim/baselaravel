<?php
namespace App\Http\Traits;

use App\Models\File;

trait HasFiles {
    public function files() {
        return $this->morphMany(File::class, 'fileable');
    }
}
