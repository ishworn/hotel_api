<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Booking;
use App\Http\Resources\BookingResource;

class BookingController extends Controller
{
    // GET /customer - List all customers
    public function index()
    {
        $bookings = Booking::with('customer')->latest()->get();
        return BookingResource::collection($bookings); // Still 200 OK
    }

    // POST /customer - Store a new customer
    public function store(Request $request)
    {
        // Step 1: Validate request data
        $validated = $request->validate([
            // Customer info
            'name'          => 'required|string|max:255',
            'email'         => 'nullable|email',
            'phone'         => 'required|string|max:20',

            // Booking info
            'guests'        => 'required|integer|min:1',
            'room_id'       => 'required|exists:rooms,id',
            'room_type'     => 'required|string',
            'room_rate'     => 'required|numeric',
            'check_in'      => 'required|date',
            'check_out'     => 'required|date|after:check_in',
            'nights'        => 'required|integer|min:1',
            'total_amount'  => 'required|numeric',
            'room_number'   => 'nullable|string',
        ]);

        // Step 2: Create or retrieve customer
        $customer = Customer::firstOrCreate(
            ['phone' => $validated['phone']],
            [
                'full_name'  => $validated['name'],
                'email' => $validated['email'],
            ]
        );

        // Step 3: Create booking with customer_id
        $booking = Booking::create([
            'customer_id'   => $customer->id,
            'guests'        => $validated['guests'],
            'room_id'       => $validated['room_id'],
            'room_type'     => $validated['room_type'],
            'room_rate'     => $validated['room_rate'],
            'check_in'      => $validated['check_in'],
            'check_out'     => $validated['check_out'],
            'nights'        => $validated['nights'],
            'total_amount'  => $validated['total_amount'],
            'room_number'   => $validated['room_number'],
        ]);

        // Step 4: Generate booking reference
        $booking->booking_reference = 'BK-' . now()->format('Ymd') . '-' . str_pad($booking->id, 3, '0', STR_PAD_LEFT);
        $booking->save();

        // Step 5: Return response
        return (new BookingResource($booking))->response()->setStatusCode(201);
    }



    // GET /customer/{id} - Show single customer
    public function show($id)
    {;
    }

    // PUT /customer/{id} - Update customer
    public function update(Request $request, $id) {}

    // DELETE /customer/{id} - Delete customer
    public function destroy($id) {}
}
