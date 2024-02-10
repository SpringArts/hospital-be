<?php

namespace App\Http\Requests;

use App\Rules\TreatmentDateRule;
use Illuminate\Foundation\Http\FormRequest;

class TreatmentTimeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'date.*' => ['required', new TreatmentDateRule()],
            'start_at' => 'required|date_format:H:i',
            'end_at' => 'required|date_format:H:i|after:start_at'
        ];

        if ($this->isMethod("PUT") || $this->isMethod("PATCH")) {
            $rules['date.*'] = ['nullable', new TreatmentDateRule()];
            $rules['start_at'] = 'nullable|date_format:H:i';
            $rules['end_at'] = 'nullable|date_format:H:i|after:start_at';
        }

        return $rules;
    }

}
