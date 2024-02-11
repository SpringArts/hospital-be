<?php
namespace App\Services\Appointment;

use App\helper\ResponseHelper;
use App\Models\TreatmentTime;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB; // Import DB facade
use Illuminate\Support\Facades\Log;

class TreatmentTimeService
{
    public static function store(array $data, $user)
    {
        try {
            // Start a database transaction
            DB::beginTransaction();

            if (!isset($data['date'], $data['start_at'], $data['end_at'])) {
                // Handle missing keys in $data array
                throw new \InvalidArgumentException('Required keys are missing in the data array.');
            }

            // Validate date/time format
            $start_at = Carbon::parse($data['start_at']);
            $end_at = Carbon::parse($data['end_at']);

            if (!$start_at || !$end_at) {
                // Handle invalid date/time format
                throw new \InvalidArgumentException('Invalid date/time format.');
            }

            $treatments = [];
            $interval = 30;
            $formData['user_id'] = $user->id;

            while ($start_at <= $end_at) {
                // Convert date array to JSON string
                $formData['date'] = json_encode($data['date']);
                $formData['time'] = $start_at->format('H:i');

                $treatment = TreatmentTime::create($formData);
                $treatments[] = $treatment;

                $start_at->addMinutes($interval);
            }

            $user->update(["role" => "doctor"]);

            // If all goes well, commit the transaction
            DB::commit();

            return $treatments;
        } catch (\Exception $e) {
            // If an error occurs, rollback the transaction
            DB::rollBack();

            // Log the error
            Log::error('Error storing treatment times: ' . $e->getMessage());

            // Return a failure response
            return ResponseHelper::fail('Error storing treatment times: ' . $e->getMessage(), null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}

