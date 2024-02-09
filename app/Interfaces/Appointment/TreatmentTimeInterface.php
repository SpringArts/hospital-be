<?php


namespace App\Interfaces\Appointment;


use App\Models\TreatmentTime;

interface TreatmentTimeInterface
{
    public function fetchAllTreatmentTimes(int $limit , int $page);

    public function fetchTreatment(int $id);

    public function store(array $data);

    public function update(array $data ,TreatmentTime $treatmentTime);

    public function delete(TreatmentTime $treatmentTime);
}
