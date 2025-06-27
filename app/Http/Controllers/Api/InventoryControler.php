<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Inventory;



class InventoryControler extends Controller
{
    // GET /customer - List all customers
    public function index()
    {
        $inventory = Inventory::with('customer')->latest()->get();

        return response()->json($inventory, 200); // Return 200 OK with inventory data
    }

    // POST /customer - Store a new customer
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'inventory_code' => 'required|string|unique:inventories,inventory_code',
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'quantity' => 'required|integer|min:0',
                'unit' => 'required|string|max:50',
                'min_stock' => 'required|integer|min:0',
                'supplier' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'last_updated' => 'required|date',
            ]);

            $inventory = Inventory::create($validated);

            return response()->json([
                'message' => 'Inventory created successfully',
                'inventory' => $inventory
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'received_data' => $request->all(),
            ], 422);
        }
    }





    // GET /customer/{id} - Show single customer
    public function show($id) {

  $inventory = Inventory::find($id);

        if (!$inventory) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json($inventory, 200); // Return 200 OK with inventory data



    }

    // PUT /customer/{id} - Update customer
    public function update(Request $request, $id) {}

    // DELETE /customer/{id} - Delete customer
    public function destroy($id) {}
}
