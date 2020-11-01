<?php
namespace App\Repositories\Permission;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface IPermissionRepository {
    /**
     * List all api logs
     * @return array [Permissions]
     */
    public function list();


    /**
     * Create an api log
     * @param Illuminate\Http\Request
     * @param Illuminate\Http\JsonResponse
     * @return ApiLog
     */
    public function create(Request $request, JsonResponse $response);
}