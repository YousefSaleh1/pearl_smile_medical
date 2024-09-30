<?php

namespace App\Http\Requests;

use App\Services\ApiResponseService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class BookingRequest extends FormRequest
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
        return [
            'service_id'   => 'required|exists:services,id',
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone_number' => 'required|regex:/^\+?[0-9]{7,15}$/',
            'message'      => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'service_id'   => trans('attributes.service'),
            'name'         => trans('attributes.name'),
            'phone_number' => trans('attributes.phone_number'),
            'email'        => trans('attributes.email'),
            'message'      => trans('attributes.message'),
        ];
    }
    /**
     *  method handles failure of Validation and return message
     * @param \Illuminate\Contracts\Validation\Validator $Validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    protected function failedValidation(Validator $Validator)
    {
        $errors = $Validator->errors()->all();
        throw new HttpResponseException(ApiResponseService::error($errors, 'general.validation_error', 422));
    }
}
