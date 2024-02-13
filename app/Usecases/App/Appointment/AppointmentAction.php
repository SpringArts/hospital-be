<?php


namespace App\Usecases\App\Appointment;


use App\Helpers\ResponseHelper;
use App\Http\Resources\AppointmentResource;
use App\Interfaces\Appointment\AppointmentInterface;
use App\Models\Appointment;
use Illuminate\Http\Response;

class AppointmentAction
{

    private $appointmentRepository;

    public function __construct(AppointmentInterface $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function fetchAllAppointments()
    {
        $limit = request()->limit ?? 10;
        $page = request()->page ?? 1;
        $data = $this->appointmentRepository->fetchAllAppointments($limit, $page);

        return response()->json([
            "message" => "successfully fetched",
            "data" => AppointmentResource::collection($data),
            "meta" => ResponseHelper::getPagination($data)
        ], 200);
    }

    public function fetchAppointment(Appointment $appointment)
    {
        return ResponseHelper::success("Successfully Fetched", new AppointmentResource($appointment), Response::HTTP_OK);
    }

    public function store($data)
    {
        $this->appointmentRepository->store($data);
        return ResponseHelper::success('Wait for a moment', null, Response::HTTP_CREATED);
    }

    public function update(array $data, Appointment $appointment)
    {
        $this->appointmentRepository->update($data, $appointment);
        return ResponseHelper::success('Successfully Updated', null, Response::HTTP_OK);
    }

    public function delete(Appointment $appointment)
    {
        $this->appointmentRepository->delete($appointment);
        return ResponseHelper::success('Successfully Deleted', null, Response::HTTP_NO_CONTENT);
    }
}
