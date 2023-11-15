<?php
namespace App\Repositories\ApiLog;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

use App\Models\ApiLog;

class ApiLogRepository implements IApiLogRepository {

    public function list() {
        
    }

    public function create(Request $request, JsonResponse $response) {
        return ApiLog::create([
            'user_id' => auth('api')->id(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'header' => json_encode($request->header()),
            'request_data' => json_encode($request->all()),
            'response_data' => $response->getContent(),
            'status' => $response->status()
        ]);
    }

    public function clear_old_logs($days) {
        ApiLog::where('created_at', '<=', Carbon::now()->subDays($days)->toDateTimeString())
            ->delete();
    }
}