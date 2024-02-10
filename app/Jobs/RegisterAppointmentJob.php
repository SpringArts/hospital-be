<?php

namespace App\Jobs;

use App\Services\Appointment\RegisterAppointmentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RegisterAppointmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $data;
    public $now;
    /**
     * Create a new job instance.
     */
    public function __construct($user , $data)
    {
        $this->user = $user;
        $this->data = $data;
        $this->now = now();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        RegisterAppointmentService::register($this->user , $this->data , $this->now);
    }
}
