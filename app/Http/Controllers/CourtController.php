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
        'total' => $request->total,
        'startTime' => $request->start_time, // Pass start time to the view
        'endTime' => $request->end_time,
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

    public function createNewCourt()
    {
        return view('admin_create_court'); // Blade file to show the create form
    }

    public function storeNewCourt(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric',
            'status' => 'required|in:available,not_available',
        ]);
    
        $court = new Court();
        $court->name = $request->name;
        $court->price = $request->price;
        $court->status = $request->status;
    
        // Handle image upload
        if ($request->hasFile('image')) {
            // Get original filename (e.g. Court 4.jpg)
            $originalFilename = $request->file('image')->getClientOriginalName();
    
            // Save the image to storage/app/public/ with original filename
            $request->file('image')->storeAs('public', $originalFilename);
    
            // Save only the filename in the database
            $court->image = $originalFilename;
        }
    
        $court->save();
    
        return redirect()->route('admin.court.create')->with('success', 'Court created successfully!');
    }

    public function showManageCourt()
    {
        $courts = Court::all();
        return view('admin-court-manage', compact('courts'));
    }

    public function editCourt($id)
    {
        $court = Court::findOrFail($id);
        return view('admin-edit-court', compact('court'));
    }

    public function destroyCourt($id)
    {
        // Find the court by ID
        $court = Court::find($id);

        // Check if court exists
        if (!$court) {
            return redirect()->route('admin-court-manage.showManageCourt')->with('error', 'Court not found.');
        }

        // Delete the court
        $court->delete();

        // Redirect back with success message
        return redirect()->route('admin-court-manage.showManageCourt')->with('success', 'Court deleted successfully.');
    }

    public function updateCourt(Request $request, $id)
    {
        $court = Court::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $court->name = $request->name;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Get original filename (e.g. Court 4.jpg)
            $originalFilename = $request->file('image')->getClientOriginalName();
    
            // Save the image to storage/app/public/ with original filename
            $request->file('image')->storeAs('public', $originalFilename);
    
            // Save only the filename in the database
            $court->image = $originalFilename;
        }

        $court->save();

        return redirect()->route('admin-court-manage.showManageCourt')->with('success', 'Court updated successfully.');
    }

    public function bookedCourts(Request $request)
    {
        // Get the search query from the input field
        $search = $request->input('search', '');

        // Fetch booked courts based on search query if present
        $bookedCourts = Booking::whereHas('court', function($query) use ($search) {
            if ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            }
        })->with('court') // Eager load the related court data
            ->get();

        return view('admin-booked-courts', compact('bookedCourts', 'search'));
    }

    
}
