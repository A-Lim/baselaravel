<?php
namespace App\Repositories\Dashboard;

use App\Models\User;
use App\Models\Dashboard;

interface IDashboardRepository {
    /**
     * List all widget types
     * @return array [WidgetType]
     */
    public function listWidgetTypes();

    /**
     * List dashboards that are public and created by user
     * @param User $user
     * @return array [Dashboard]
     */
    public function list(User $user);

    /**
     * Find a dashboard by id
     * @param integer $id
     * @return Dashboard
     */
    public function find($id);

    /**
     * Creates a dashboard
     * @param array $data
     * @param User $user
     * @return Dashboard
     */
    public function create($data, User $user);

    /**
     * Updates a dashboard
     * @param Dashboard $dashboard
     * @param array $data
     * @param User $user
     * @return Dashboard
     */
    public function update(Dashboard $dashboard, $data, User $user);
}