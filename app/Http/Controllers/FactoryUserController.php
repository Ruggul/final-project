<?php

namespace App\Http\Controllers;

use App\Models\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FactoryController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        $factories = Factory::paginate(10);
        return view('factories.index', compact('factories'));
    }

    //Show the form for creating a new resource.
    public function create()
    {
        return view('factories.create');
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:factory',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        Factory::create($validated);

        return redirect()
            ->route('factories.index')
            ->with('success', 'Factory created successfully');
    }

    //Display the specified resource.
    public function show(string $id)
    {
        $factory = Factory::findOrFail($id);
        return view('factories.show', compact('factory'));
    }

    //Show the form for editing the specified resource.
    public function edit(string $id)
    {
        $factory = Factory::findOrFail($id);
        return view('factories.edit', compact('factory'));
    }

    //Update the specified resource in storage.
    public function update(Request $request, string $id)
    {
        $factory = Factory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:factory,email,' . $id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $factory->update($validated);

        return redirect()
            ->route('factories.index')
            ->with('success', 'Factory updated successfully');
    }

    //Remove the specified resource from storage.
    public function destroy(string $id)
    {
        $factory = Factory::findOrFail($id);
        $factory->delete();

        return redirect()
            ->route('factories.index')
            ->with('success', 'Factory deleted successfully');
    }
}