<?php
namespace App\Repositories\Dashboard;

use App\Models\User;
use App\Models\Dashboard;

interface IDashboardRepository {
    
    public function listWidgetTypes();

    public function list(User $user);

    public function find($id);

    public function create($data, User $user);

    public function update(Dashboard $dashboard, $data, User $user);
}