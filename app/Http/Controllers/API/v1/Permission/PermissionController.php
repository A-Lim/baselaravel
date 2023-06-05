<?php

namespace App\Http\Controllers\API\v1\Permission;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Repositories\Permission\IPermissionRepository;
use App\Repositories\User\IUserRepository;

class PermissionController extends ApiController {

    private $permissionRepository;
    private $userRepository;

    public function __construct(IPermissionRepository $iPermissionRepository,
        IUserRepository $iUserRepository) {
        $this->middleware('auth:api');
        $this->permissionRepository = $iPermissionRepository;
        $this->userRepository = $iUserRepository;
    }

    public function list(Request $request) {
        $permissions = $this->permissionRepository->list(true);
        return $this->responseWithData(200, $permissions);
    }

    public function myPermissions(Request $request) {
        $user = auth()->user();
        $permissions = $this->userRepository->permissions($user);
        return $this->responseWithData(200, $permissions);
    }
}
