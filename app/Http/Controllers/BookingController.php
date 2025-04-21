<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'date' => 'required|date',
        ]);
    
        $bookedSlots = Booking::where('court_id', $request->court_id)
            ->where('booking_date', $request->date)
            ->get(['start_time', 'end_time']);
    
        return response()->json($bookedSlots);
    }

    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $booking->delete();

        return redirect()->back()->with('success', 'Booking deleted successfully. Refund will be processed soon.');
    }


    // Process Payment and Show Confirmation
    public function processPayment(Request $request)
    {
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'payment_method' => 'required|in:credit_debit,e_wallet',
        ]);
    
        // Create a booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'court_id' => $request->court_id,
            'booking_date' => $request-> date, // Or use a date picker from the form
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'hours' => $request->hours,
            'payment_method' => $request->payment_method,
            'status' => 'confirmed',
            'totalPrice' => $request->total,
            
        ]);

        $request->session()->put('payment_completed', true);
        $request->session()->put('completed_booking_id', $booking->id);

    
        // Return the booking details to the confirmation page
        return redirect()->route('booking-confirmation', ['booking' => $booking->id]);
    }
    

    public function showConfirmation(Booking $booking)
    {
        // Eager load the related Court and User
        $booking->load('court', 'user');
    
        return view('booking-confirmation', [
            'booking' => $booking,
        ]);
    }
    
}