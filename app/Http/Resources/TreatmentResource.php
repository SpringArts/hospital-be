<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class TreatmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->getDays(),
            'time' => $this->time,
            'isVisible' => $this->is_visible,
            'createdAt' => Carbon::parse($this->created_at)->format("Y m d H:i:s")
        ];
    }
}
