<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [ "type" , "status" , "time" , "note" , "ticket" , "is_visible" ];

    public function userAppointments()
    {
        return $this->belongsToMany(User::class, 'users_appointments' , 'appointment_id', 'user_id');
    }

    public function doctors()
    {
        return $this->belongsToMany(User::class, 'users_appointments' , 'appointment_id', 'doctor_id');
    }
}
