<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AfterOrBeforeTime;

class StoreGymRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gym_name' => 'required|string|max:100',
            'manager_name' => 'required|string|max:100',
            'gym_phone' => 'required|numeric|digits_between:10,11',
            'manager_phone' => 'required|numeric|digits_between:10,11',
            'manager_email' => 'required|email|unique:gyms,manager_email',
            'manager_cpf' => 'required|numeric|digits:11|unique:gyms,manager_cpf',
            'zip_code' => 'required|numeric|digits:8',
            'state' => 'required|string|size:2',
            'city' => 'required|string|max:100',
            'neighborhood' => 'required|string|max:100',
            'street' => 'required|string|max:100',
            'number' => 'required|numeric',
            'complement' => 'nullable|string|max:255',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'gym_name' => $this->gymName,
            'manager_name' => $this->managerName,
            'gym_phone' => $this->gymPhone,
            'manager_phone' => $this->managerPhone,
            'zip_code' => $this->zipCode,
            'manager_email' => $this->manager_email,
            'manager_cpf' => $this->manager_cpf,
            'state' => $this->state,
            'city' => $this->city,
            'neighborhood' => $this->neighborhood,
            'street' => $this->street,
            'number' => $this->number,
            'complement' => $this->complement,
        ]);
    }
}