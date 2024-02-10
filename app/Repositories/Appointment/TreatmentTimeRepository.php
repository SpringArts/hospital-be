<?php


namespace App\Repositories\Appointment;

use App\Interfaces\Appointment\TreatmentTimeInterface;
use App\Jobs\TreatmentTimeJob;
use App\Models\TreatmentTime;
use App\Models\User;

class TreatmentTimeRepository implements TreatmentTimeInterface
{

    public function fetchAllTreatmentTimes(int $limit, int $page)
    {
        return TreatmentTime::where('is_visible', 1)
            ->when(request('time'), function ($q) {
                // Adjust this condition based on your actual 'time' filtering logic
                // For example, if 'time' is a separate column and you want to match exact time
                $q->where('time', request('time'));
            })
            ->when(request('date'), function ($q) {
                // Use whereJsonContains to match all provided dates
                $q->whereJsonContains('date', request('date'));
            })
            ->paginate($limit, ['*'], 'page', $page)
            ->withQueryString();
    }

    public function fetchTreatment(int $id)
    {
        return TreatmentTime::find($id);
    }

    public function store(array $data)
    {
        $admin = User::where('role', 'admin')->get();
        return TreatmentTimeJob::dispatch($admin , auth()->user() , $data);
    }

    public function update(array $data, TreatmentTime $treatmentTime)
    {
        return $treatmentTime->update($data);
    }

    public function delete(TreatmentTime $treatmentTime)
    {
        return $treatmentTime->update(['is_visible' => false]);
    }
}
