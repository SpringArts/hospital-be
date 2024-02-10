<?php


namespace App\Usecases\App\Appointment;


use App\helper\ResponseHelper;
use App\Http\Resources\TreatmentResource;
use App\Interfaces\Appointment\TreatmentTimeInterface;
use App\Models\TreatmentTime;
use Illuminate\Http\Response;

class TreatmentAction
{
    private $treatmentRepository;

    public function __construct(TreatmentTimeInterface $treatmentRepository)
    {
        $this->treatmentRepository = $treatmentRepository;
    }

    public function fetchAll()
    {
        $limit = request()->limit ?? 10;
        $page = request()->page ?? 1;
        $data = $this->treatmentRepository->fetchAllTreatmentTimes($limit , $page);
        return ResponseHelper::success("Successfully Fetched From Treatment table." , TreatmentResource::collection($data) , Response::HTTP_OK);
    }

    public function fetchTreatment(TreatmentTime $treatmentTime)
    {
        return ResponseHelper::success('Successfully Fetched', new TreatmentResource($treatmentTime), Response::HTTP_OK);
    }

    public function store(array $data)
    {
        $this->treatmentRepository->store($data);
        return ResponseHelper::success('Please For a minute', null , Response::HTTP_CREATED);
    }

    public function update(array $data , TreatmentTime $treatmentTime)
    {
        $this->treatmentRepository->update($data , $treatmentTime);
        return ResponseHelper::success('Successfully updated' , null , Response::HTTP_OK);
    }

    public function delete(TreatmentTime $treatmentTime)
    {
        $this->treatmentRepository->delete($treatmentTime);
        return ResponseHelper::success('Successfully deleted' , null , Response::HTTP_OK);
    }
}
