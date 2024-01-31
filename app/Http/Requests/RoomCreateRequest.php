<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomCreateRequest extends FormRequest
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

//        dd($this->request);
        return [
            'number' => 'required',
            'type' => 'required|in:normal,tiny,big',
            'pricePerNight' => 'required',
            'status' => 'required|in:available,occupied'
        ];
    }

    public function messages()
    {
        return [
            'number.required' => 'Number is required',
            'type.required' => 'Type is required',
            'type.in' => 'Type should be normal, tiny or big',
            'pricePerNight.required' => 'Price is required',
            'status.required' => 'Status is required',
            'status.in' => 'Status should be available or occupied'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
           'price_per_night' => $this->pricePerNight
        ]);
    }
}
