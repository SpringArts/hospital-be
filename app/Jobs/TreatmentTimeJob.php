<?php

namespace App\Jobs;

use App\Notifications\TreatmentTimeNotification;
use App\Services\Appointment\TreatmentTimeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class TreatmentTimeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user ;
    public $admin;
    public $data;
    /**
     * Create a new job instance.
     */
    public function __construct($admin , $user , $data)
    {
        $this->admin = $admin;
        $this->user = $user;
        $this->$data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $treatment = TreatmentTimeService::store($this->data , $this->user);
        Notification::send($this->admin , new TreatmentTimeNotification($this->user, $treatment));
    }
}
