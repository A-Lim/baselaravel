<?php
namespace App\Repositories\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface IFileRepository {

    public function uploadOne($folder, UploadedFile $files, $fileableType = null, $fileableId = null);

    public function uploadMultiple($folder, array $files, $fileableType = null, $fileableId = null);

    public function clear_old_files($days);
}