<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyStaff
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookingCreated $event): void
    {
        dd($event->booking->total_price);

        $staffEmails = ['manager@gmail.com', 'staff@gmail.com'];

        foreach ($staffEmails as $email) {
//            Mail::to($email)->send()
        }
    }
}
