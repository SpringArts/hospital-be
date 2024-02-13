<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
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
            'doctor_id' => 'required|integer|exists:users,id',
            'time' => 'required|date|after:today',
            'note' => 'required|string',
            'type' => 'nullable|in:inPerson,liveChat,videoChat',
            'status' => 'nullable|in:ongoing,pending,cancel,complete'
        ];

        if ($this->isMethod("PUT") || $this->isMethod("PATCH")) {
            $rules['doctor_id'] = 'nullable|integer|exists:users,id';
            $rules['time'] = 'nullable|date';
            $rules['note'] = 'nullable|string';
        }

        return $rules;
    }
}
