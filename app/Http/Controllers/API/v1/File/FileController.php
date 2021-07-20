<?php

namespace App\Http\Controllers\API\v1\File;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Requests\File\UploadRequest;
use App\Repositories\File\IFileRepository;

use App\File;

class FileController extends ApiController {

    private $fileRepository;

    public function __construct(IFileRepository $iFileRepository) {
        $this->middleware('auth:api');
        $this->fileRepository = $iFileRepository;
    }

    public function upload(UploadRequest $request) {
        $file = $this->fileRepository->uploadMultiple($request->folder, $request->all()['files']);
        return $this->responseWithMessageAndData(200, $file, 'File(s) uploaded.');
    }

    public function delete(File $file, Request $request) {
        $file->delete();
        return $this->responseWithMessage(200, 'File deleted.');
    }
}
