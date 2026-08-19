<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;

class CrudController extends Controller
{
    public function index()
    {
        $families = Family::latest()->get();

        return view('welcome', compact('families'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'relation' => 'required|string|max:255',
            'gender' => 'required|string|max:50',
            'dob' => 'required|string|max:255',
        ]);

        Family::create($validated);

        return redirect()->route('families.index')->with('success', 'Family member added successfully.');
    }

    public function edit($id)
    {
        $family = Family::findOrFail($id);
        $families = Family::latest()->get();

        return view('welcome', compact('family', 'families'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'relation' => 'required|string|max:255',
            'gender' => 'required|string|max:50',
            'dob' => 'required|string|max:255',
        ]);

        $family = Family::findOrFail($id);
        $family->update($validated);

        return redirect()->route('families.index')->with('success', 'Family member updated successfully.');
    }

    public function destroy($id)
    {
        $family = Family::findOrFail($id);
        $family->delete();

        return redirect()->route('families.index')->with('success', 'Family member deleted successfully.');
    }
}
