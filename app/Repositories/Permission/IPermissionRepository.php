<?php
namespace App\Repositories\ApiLog;

interface IApiLogRepository {
     /**
     * List all permissions
     * @return array [Permissions]
     */
    public function list();
}