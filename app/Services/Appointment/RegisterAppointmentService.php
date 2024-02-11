<?php

namespace App\Services\Appointment;

use App\Models\Appointment;
use App\Models\TreatmentTime;
use App\Models\User;
use App\Notifications\AppointmentNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class RegisterAppointmentService
{
    public static function register($user, $data, $now)
    {
        try {
            // Begin transaction
            DB::beginTransaction();

            $admins = User::where('role', 'admin')->get();
            $doctorId = $data['doctor_id'];

            $appointmentTime = Carbon::parse($data['time']);
            $currentDate = $now;

            Log::info("Here is appointment time : ". $appointmentTime);

            $formData["type"] = $data["type"];
            $formData["time"] = $appointmentTime;
            $formData["note"] = $data['note'];
            $formData["ticket"] = self::generateBookingId();

            //data for pivot table
            $pData ['user_id'] = $user->id;
            $pData ['doctor_id'] = $doctorId;

            if (self::isAvailableTime($doctorId, $appointmentTime)) {
                Notification::send([$user, ...$admins], new AppointmentNotification("Appointment time is unavailable. Please choose another time.", $user));
            }

            $existingAppointment = self::findExistingAppointment($doctorId, $appointmentTime);

            if ($existingAppointment) {
                Notification::send($user, new AppointmentNotification('You cannot book this appointment. Please choose another time.', $user));
            }

            if (self::isFutureOrCurrentDate($appointmentTime, $currentDate)) {
                $appointment = self::createAppointment($formData, $user);
                $pData["appointment_id"] = $appointment->id;
                self::createUsersAppointmentPivot($pData, $appointment);
            }

            Notification::send($admins , new AppointmentNotification($user->name." is trying to register an appointment." , $user));

            // Commit transaction
            DB::commit();
            return Log::info("Successfully Inserted");
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            // Log the error
            Log::error('Error registering appointment: ' . $e->getMessage());

            // Handle the error and return appropriate response
            // You can also re-throw the exception to bubble it up
            return response()->json(['error' => 'An error occurred while registering the appointment.'], 500);
        }
    }

    private static function isAvailableTime($userId, $appointmentTime)
    {
        $date = Carbon::parse($appointmentTime)->format("N");
        $time = Carbon::parse($appointmentTime)->format("H:i:s");
        return TreatmentTime::where('user_id', $userId)
            ->where('date', "LIKE", "%$date%")
            ->where('time', $time)
            ->exists();
    }


    private static function findExistingAppointment($doctorId, $appointmentTime)
    {
        return Appointment::join('users_appointments', 'appointments.id', '=', 'users_appointments.appointment_id')
            ->where('users_appointments.doctor_id', $doctorId)
            ->where('appointments.time', $appointmentTime)
            ->first();
    }

    private static function isFutureOrCurrentDate($appointmentDate, $currentDate)
    {
        return $appointmentDate->greaterThanOrEqualTo($currentDate);
    }

    private static function createAppointment($formData, $user)
    {
        $formData['patient_id'] = $user->id;
        return Appointment::create($formData);
    }

    private static function createUsersAppointmentPivot(array $pData, Appointment $appointment)
    {
        return $appointment->userAppointments()->attach($pData);
    }

    private static function generateBookingId()
    {
        return substr(crc32(uniqid()), 0, 6);
    }
}
