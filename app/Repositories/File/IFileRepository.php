<?php
namespace App\Repositories\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Models\File;

interface IFileRepository {
    /**
     * Upload one file
     * 
     * @param string
     * @param array
     * @param string $fileableType,
     * @param int $fileableId
     * @return File
     */
    public function uploadOne($folder, UploadedFile $files, $fileableType = null, $fileableId = null);

    /**
     * Upload Multple files
     * 
     * @param string
     * @param array
     * @param string $fileableType,
     * @param int $fileableId
     * @return [File]
     */
    public function uploadMultiple($folder, array $files, $fileableType = null, $fileableId = null);
}