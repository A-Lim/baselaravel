<?php
namespace App\Repositories\Appointment;

use App\Models\Appointment;

interface IAppointmentRepository {

    public function list($data, $paginate = false);

    public function create($data);

    public function update(Appointment $appointment, $data);
}