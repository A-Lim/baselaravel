<?php
namespace App\Repositories\Dashboard;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\WidgetType;
use App\Models\Dashboard;

class DashboardRepository implements IDashboardRepository {

    public function listWidgetTypes() {
        return WidgetType::all();
    }

    public function list(User $user) {
        return Dashboard::where(function ($query) use ($user) {
            $query->where('created_by', $user->id)
                ->orWhere('public', true);
        })
        ->with('widgets')
        ->get();
    }

    public function find($id) {
        return Dashboard::with('widgets')
            ->where('id', $id)
            ->firstOrFail();
    }

    public function create($data, User $user) {
        $data['created_by'] = $user->id;

        DB::beginTransaction();
        $dashboard = Dashboard::create($data);
        if (isset($data['widgets'])) {
            $dashboard->widgets()->createMany($data['widgets']);
        }
        DB::commit();

        return $this->find($dashboard->id);
    }

    public function update(Dashboard $dashboard, $data, User $user) {
        $data['updated_by'] = $user->id;
        unset($data['uuid']);

        DB::beginTransaction();
        $dashboard->fill($data);
        $dashboard->widgets()->delete();
        $dashboard->widgets()->createMany($data['widgets']);
        $dashboard->save();
        DB::commit();

        return $this->find($dashboard->id);
    }
}
