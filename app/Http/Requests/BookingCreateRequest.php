<?php

namespace App\Http\Requests;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookingCreateRequest extends FormRequest
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
            'roomId' => [
                'required',
                'exists:rooms,id',
                Rule::unique('bookings', 'room_id')
                    ->where(function (Builder $query) {
                        $query->whereBetween('check_in_date', [$this->input('checkInDate'), $this->input('checkOutDate')])
                            ->orWhereBetween('check_out_date', [$this->input('checkInDate'), $this->input('checkOutDate')]);
                })
                ],
            'customerId' => 'required|exists:customers,id',
            'checkInDate' => 'required|date_format:Y-m-d|after_or_equal:today',
            'checkOutDate' => 'required|date_format:Y-m-d|after:checkInDate'
        ];
    }

    public function messages()
    {
        return [
            'roomId.required' => 'RoomId is required',
            'roomId.exists' => 'RoomId is not a valid id',
            'roomId.unique' => 'Room is occupied for this period',
            'customerId.required' => 'CustomerId is required',
            'customerId.exists' => 'CustomerId is not a valid id',
            'checkInDate.required' => 'CheckInDate is required',
            'checkInDate.date_format' => 'CheckInDate must be in format Y-m-d',
            'checkInDate.after_or_equal' => 'CheckInDate must be after of equal to today date',
            'checkOutDate.required' => 'checkOutDate is required',
            'checkOutDate.date_format' => 'checkOutDate must be in format Y-m-d',
            'checkOutDate.after' => 'checkOutDate must be after checkInDate',

        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'room_id' => $this->roomId,
            'customer_id' => $this->customerId,
            'check_in_date' => $this->checkInDate,
            'check_out_date' => $this->checkOutDate,
        ]);
    }
}
