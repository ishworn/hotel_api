<?php

namespace App\Http\Controllers\Api;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    public function index()
    {
        return Department::all();
    }

    public function store(Request $request)
    {

        try {
            $request->validate(['name' => 'required|string|unique:departments']);
            return Department::create($request->only('name'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create department: ' . $e->getMessage()], 500);
        }
    }

    public function show(Department $department)
    {
        return $department->load('positions');
    }

    public function update(Request $request, Department $department)
    {
        $request->validate(['name' => 'required|string|unique:departments,name,' . $department->id]);
        $department->update($request->only('name'));
        return $department;
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return response()->noContent();
    }
}
