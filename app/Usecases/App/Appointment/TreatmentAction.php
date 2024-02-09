<?php


namespace App\Usecases\App\Appointment;


use App\Interfaces\Appointment\TreatmentTimeInterface;

class TreatmentAction
{
    private $treatmentRepository;

    public function __construct(TreatmentTimeInterface $treatmentRepository)
    {
        $this->treatmentRepository = $treatmentRepository;
    }
}
