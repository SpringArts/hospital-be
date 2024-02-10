<?php

namespace App\Providers;

use App\Interfaces\Appointment\AppointmentInterface;
use App\Interfaces\Appointment\TreatmentTimeInterface;
use App\Repositories\Appointment\AppointmentRepository;
use App\Repositories\Appointment\TreatmentTimeRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            AppointmentInterface::class , AppointmentRepository::class
        );
        $this->app->bind(
            TreatmentTimeInterface::class , TreatmentTimeRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
