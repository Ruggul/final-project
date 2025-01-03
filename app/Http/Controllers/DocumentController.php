<?php

namespace App\Http\Controllers;

use App\Models\Factory;
use Illuminate\Http\Request;

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
        $request->validate(Factory::$rules);
        Factory::create($request->all());
        return redirect()->route('factories.index')->with('success', 'Factory created successfully');
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
        $request->validate(Factory::$rules);
        $factory->update($request->all());
        return redirect()->route('factories.index')->with('success', 'Factory updated successfully');
    }

    //Remove the specified resource from storage.
    public function destroy(string $id)
    {
        $factory = Factory::findOrFail($id);
        $factory->delete();
        return redirect()->route('factories.index')->with('success', 'Factory deleted successfully');
    }
}