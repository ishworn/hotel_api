<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        return Position::with('department')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'department_id' => 'required|exists:departments,id',
           ' role_id' => 'nullable|exists:roles,id',
        ]);

        return Position::create($request->only('title', 'department_id' , 'role_id'));
    }

    public function show(Position $position)
    {
        return $position->load('department');
    }

    public function update(Request $request, Position $position)
    {
        $request->validate([
            'title' => 'required|string',
            'department_id' => 'required|exists:departments,id',
        ]);

        $position->update($request->only('title', 'department_id'));
        return $position;
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return response()->noContent();
    }
}
