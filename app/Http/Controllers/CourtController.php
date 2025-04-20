<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Court;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class CourtController extends Controller
{
    //
    public function showCourtName(){

        $data = Court::select('id','name','status','price','image')->paginate(5);
        return view ('admin-court-details',['courts'=> $data]);
    }

    public function updateStatus(Request $request)
    {
        \Log::info('Submitted data:', $request->all()); // Add this
    
        $statuses = $request->input('status');
    
        foreach ($statuses as $id => $status) {
            $court = \App\Models\Court::find($id);
            if ($court) {
                $court->status = $status;
                $court->save();
            }
        }
    
        return redirect()->back()->with('success', 'Court statuses updated successfully!');
    }

    public function showChangePriceForm()
    {
        // Get the price of the first court record (or you can use average(), max(), etc.)
        $originalPrice = Court::first()->price ?? null;
    
        return view('admin-adjust-pricing', compact('originalPrice'));
    }

    public function updateAllPrices(Request $request)
    {
        $request->validate([
            'new_price' => 'required|numeric|min:0',
        ]);

        \App\Models\Court::query()->update(['price' => $request->new_price]);

        return redirect()->route('courts.changePrice')->with('success', 'All court prices updated successfully!');
    }

    public function courtDetails($id)
{
    $court = Court::findOrFail($id);
    return view('court-details', compact('court'));
}

public function showPayment(Request $request)
{
    $court = Court::findOrFail($request->court_id);

    return view('payment', [
        'court' => $court,
        'date' => $request->date,
        'hours' => $request->hours,
        'total' => $request->total
    ]);
}

// public function showBooking()
// {
//     $availableCourts = Court::all();

//     $userBookings = Booking::with('court')
//         ->where('user_id', auth()->id())
//         ->orderBy('date', 'desc')
//         ->get();

//     return view('court-listing', compact('availableCourts', 'userBookings'));
// }

public function showListing()
{   
    // Get all courts where status is 'available'
    $availableCourts = Court::where('status', 'available')->get();

    $userBookings = Booking::with('court')
    ->where('user_id', auth()->id())
    ->orderBy('booking_date', 'desc')
    ->get();

    // Pass to view
    return view('court-listing', compact('availableCourts', 'userBookings'));
}
}
