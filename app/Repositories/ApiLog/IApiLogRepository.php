<?php
namespace App\Repositories\ApiLog;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface IApiLogRepository {

    public function list();

    public function create(Request $request, JsonResponse $response);

    public function clear_old_logs($days);
}