<?php


namespace App\Repositories\Appointment;


use App\Interfaces\Appointment\AppointmentInterface;
use App\Jobs\RegisterAppointmentJob;
use App\Models\Appointment;

class AppointmentRepository implements AppointmentInterface
{

    public function fetchAllAppointments(int $limit , int $page)
    {
        $orderBy = request('orderBy') ?? "asc";
        return Appointment::where('is_visible', 1)
        ->when(request('order'), function ($q) use($orderBy){
            $q->orderBy(request('order') , strtoupper($orderBy));
        })
            ->when(request('keyword') , function ($q){
                $keyword = request('keyword');
                $q->orWhere('note' , $keyword)
                    ->orWhere('ticket' , $keyword);
            })
            ->when(request('type'), function ($q) {
                $type = request('type');
                $q->where('type',$type);
            })
            ->when(request('status'), function ($q) {
                $status = request('status');
                $q->where('status',$status);
            })
            ->paginate($limit, ['*'], 'page' , $page)
            ->withQueryString();
    }

    public function fetchSingleAppointments(int $int)
    {
        return Appointment::find($int);
    }

    public function store(array $data)
    {
        return RegisterAppointmentJob::dispatch(auth()->user() ,$data);
    }

    public function update(array $data, Appointment $appointment)
    {
        return $appointment->update($data);
    }

    public function delete(Appointment $appointment)
    {
        return $appointment->update(['is_visible' => false]);
    }
}
