<?php

namespace App\Http\Controllers\API\v1\Appointment;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Appointment\CreateRequest;
use App\Http\Requests\Appointment\UpdateRequest;
use App\Repositories\Appointment\IAppointmentRepository;

class AppointmentController extends ApiController
{
    private $appointmentRepository;

    public function __construct(IAppointmentRepository $iAppointmentRepository) {
        $this->middleware('auth:api');
        $this->appointmentRepository = $iAppointmentRepository;
    }

    public function list(Request $request) {
        $this->authorize('viewAny', Appointment::class);

        $appointment = $this->appointmentRepository->list($request->all(), true);
        return $this->responseWithData(200, $appointment);
    }

    public function create(CreateRequest $request) {
        $this->authorize('create', Appointment::class);
        $appointment = $this->appointmentRepository->create($request->all());
        return $this->responseWithMessageAndData(201, $appointment, 'Appointment created.');
    }

    public function update(UpdateRequest $request, Appointment $appointment) {
        $this->authorize('update', $appointment);
        $appointment = $this->appointmentRepository->update($appointment, $request->validated());
        return $this->responseWithMessageAndData(201, $appointment, 'Appointment updated.');
    }

    public function delete(Appointment $appointment) {
        $this->authorize('delete', $appointment);
        $this->appointmentRepository->delete($appointment);
        return $this->responseWithMessage(200, 'Appointment deleted.');
    }
}
