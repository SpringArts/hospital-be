<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentTime extends Model
{
    use HasFactory;
    protected $fillable = [
        'time',
        'date',
        'user_id',
        'is_visible',
    ];

    public function getDays()
    {
        $dayMapping = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday',
        ];

        $days = [];

        // Decode JSON string to array if necessary
        $dateArray = is_string($this->date) ? json_decode($this->date, true) : $this->date;

        foreach ($dateArray as $day) {
            if (isset($dayMapping[$day])) {
                $days[] = $dayMapping[$day];
            }
        }

        return $days;
    }
}
