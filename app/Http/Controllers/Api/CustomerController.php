<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    // GET /customer - List all customers
    public function index()
    {
        $customers = Customer::all();
        return response()->json($customers);
    }

    // POST /customer - Store a new customer
 public function store(Request $request)
{
    $validated = $request->validate([
        'full_name'    => 'required|string|max:255',
        'email'        => 'nullable|email|unique:customers,email',
        'phone'        => 'nullable|string|max:20',
        'status'       => 'nullable|string|max:50',
        'address'      => 'nullable|string',
        'city'         => 'nullable|string|max:100',
        'country'      => 'nullable|string|max:100',
        'postal_code'  => 'nullable|string|max:20',
        'notes'        => 'nullable|string',
        'document'     => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048', // 2MB max
    ]);

    // Handle document upload if exists
    if ($request->hasFile('document')) {
        $path = $request->file('document')->store('documents', 'public');
        $validated['document'] = $path;
    }

    $customer = Customer::create($validated);

    return response()->json([
        'message' => 'Customer created successfully',
        'customer' => $customer
    ], 201);
}


    // GET /customer/{id} - Show single customer
    public function show($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json($customer);
    }

    // PUT /customer/{id} - Update customer
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|nullable|email|unique:customers,email,' . $customer->id,
            'phone' => 'sometimes|nullable|string|max:20',
        ]);

        $customer->update($validated);

        return response()->json([
            'message' => 'Customer updated successfully',
            'customer' => $customer
        ]);
    }

    // DELETE /customer/{id} - Delete customer
    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully']);
    }
}
