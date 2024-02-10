<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\TreatmentTimeRequest;
use App\Models\TreatmentTime;
use App\Usecases\App\Appointment\TreatmentAction;
use Illuminate\Http\Request;

class TreatmentTimeApiController extends Controller
{
    protected $treatmentTimeAction;
    public function __construct(TreatmentAction $treatmentTimeAction)
    {
        $this->treatmentTimeAction = $treatmentTimeAction;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->treatmentTimeAction->fetchAll();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->treatmentTimeAction->store($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(TreatmentTime $treatmentTime)
    {
        return $this->treatmentTimeAction->fetchTreatment($treatmentTime);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TreatmentTimeRequest $request, TreatmentTime $treatmentTime)
    {
        return $this->treatmentTimeAction->update($request->all() , $treatmentTime);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TreatmentTime $treatmentTime)
    {
        return $this->treatmentTimeAction->delete($treatmentTime);
    }
}
