<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use Illuminate\Validation\Rule;
use App\Models\User;

class EmployeeController extends Controller
{
    // List all employees
    public function index()
    {
        $employees = Employee::with(['position.department', 'roles'])->latest()->get();
        return EmployeeResource::collection($employees);
    }

    // Store new employee
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:employees',
            'phone'       => 'required|string|max:20',
            'status'      => 'required|in:active,inactive',
            'hire_date'   => 'required|date',
            'schedule'    => 'required|string',
            'position_id' => 'required|exists:positions,id',
            
        ]);

        $employee = Employee::create($validated);


        $user = User::create([
            'name' => $employee->name,
            'email' => $employee->email,
            'password' => bcrypt('default1234'),
        ]);

        $position = Position::with('role')->find($employee->position_id);
        if ($position && $position->role) {
            $user->assignRole($position->role->name);
        }

        // 4. Update employee with user_id
        $employee->user_id = $user->id;
        $employee->save();

        return new EmployeeResource($employee->load(['position.department', 'roles']));
    }

    // Show a specific employee
    public function show(Employee $employee)
    {
        return new EmployeeResource($employee->load(['position.department', 'roles']));
    }

    // Update employee
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'email'       => ['sometimes', 'email', Rule::unique('employees')->ignore($employee->id)],
            'phone'       => 'sometimes|string|max:20',
            'status'      => 'sometimes|in:active,inactive',
            'hire_date'   => 'sometimes|date',
            'schedule'    => 'sometimes|string',
            'position_id' => 'sometimes|exists:positions,id',
            'role'        => 'nullable|exists:roles,name',
        ]);

        $employee->update($validated);

        if (isset($validated['role'])) {
            $employee->syncRoles([$validated['role']]);
        }

        return new EmployeeResource($employee->load(['position.department', 'roles']));
    }

    // Delete employee
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
