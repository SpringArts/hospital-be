<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentResquest;
use App\Models\Appointment;
use App\Usecases\App\Appointment\AppointmentAction;
use Illuminate\Http\Request;

class AppointmentApiController extends Controller
{
    protected $appointmentAction;

    public function __construct(AppointmentAction $appointmentAction)
    {
        $this->appointmentAction = $appointmentAction;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->appointmentAction->fetchAllAppointments();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentResquest $request)
    {
        return $this->appointmentAction->store($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        return $this->appointmentAction->fetchAppointment($appointment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        return $this->appointmentAction->update($request->all(), $appointment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        return $this->appointmentAction->delete($appointment);
    }
}
