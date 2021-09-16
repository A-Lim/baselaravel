<?php

namespace App\Http\Controllers\API\v1\Dashboard;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use Carbon\Carbon;

class DashboardController extends ApiController {

    private $dashboardRepository;

    public function __construct() {
        $this->middleware('auth:api');
    }
}
