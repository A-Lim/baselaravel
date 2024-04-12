<?php
namespace App\Repositories\Appointment;

use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentRepository implements IAppointmentRepository {

    public function list($data, $paginate = false) {
        $limit = isset($data['limit']) ? $data['limit'] : 10;

        $query = Appointment::buildQuery($data);

        if ($paginate)
            return $query->paginate($limit);

        
        return $query->get();
    }

    public function create($data) {
        $data['created_at'] = @$data['created_at'] 
            ? Carbon::parse($data['created_at'])
            : Carbon::now();
        $data['created_by'] = auth()->id();

        DB::beginAppointment();
            $appointment = Appointment::create($data);
            $appointment->packages()
                ->sync($data['customerpackage_ids']);
        DB::commit();
        
        return $appointment;
    }

    public function update(Appointment $appointment, $data) {
        $data['updated_by'] = auth()->id();

        $pivot = [];
        foreach ($data['customerpackages'] as $customer_package) {
            $pivot[$customer_package['id']] = ['amount' => $customer_package['amount']];
        }

        DB::beginAppointment();
            $appointment->fill($data);
            $appointment->save();
            $appointment->packages()
                ->sync($data['customerpackage_ids']);
        DB::commit();
        
        return $appointment;
    }

    public function delete(Appointment $appointment) {
        $appointment->delete();
    }
}
