<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;

class PositionController extends Controller
{
    // Show all data
    public function index(Request $request)
    {
        $query = Position::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $positions = $query->paginate(10);
        $positions->appends($request->all());
        return view('positions.index', compact('positions'));
    }

    // Show create page
    public function create()
    {
        return view('positions.create');
    }

    // Store data
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Position::create([
            'name' => $request->name
        ]);

        return redirect()->route('positions.index')
                         ->with('success', 'Inserted Successfully');
    }

    // Edit page
    public function edit($id)
    {
        $position = Position::findOrFail($id);

        return view('positions.edit', compact('position'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $position = Position::findOrFail($id);

        $position->update([
            'name' => $request->name
        ]);

        return redirect()->route('positions.index')
                         ->with('success', 'Updated Successfully');
    }

    // Delete
    public function destroy($id)
    {
        $position = Position::findOrFail($id);

        $position->delete();

        return redirect()->route('positions.index')
                         ->with('success', 'Deleted Successfully');
    }
}