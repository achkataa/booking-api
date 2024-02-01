<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'customer_id', 'check_in_date', 'check_out_date', 'total_price'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public static function createWithTotalPrice($attributes) {

        $room = Room::findOrFail($attributes['room_id']);
        $pricePerNight = $room->price_per_night;

        $fromDate = Carbon::parse($attributes['check_in_date']);
        $toDate = Carbon::parse($attributes['check_out_date']);

        $diffDays = $fromDate->diffInDays($toDate);

        $totalPrice = $pricePerNight * $diffDays;

        $attributes['total_price'] = $totalPrice;

        return static::create($attributes);


    }

    protected static function boot()
    {
        parent::boot();

        static::created(function (Booking $booking) {
            $booking->payments()->create([
                'amount' => $booking->total_price,
                'payment_date' => Carbon::today(),
                'status' => 'pending'
            ]);
        });
    }
}
