<?php


namespace App\Interfaces\Appointment;


use App\Models\Appointment;

interface AppointmentInterface {
    public function fetchAllAppointments(int $limit , int $page);

    public function fetchSingleAppointments(int $int);

    public function store(array $data);

    public function update(array $data,Appointment $appointment);

    public function delete(Appointment $appointment);
}
