<?php

namespace App\Http\Controllers;

use App\Models\Factory;
use Illuminate\Http\Request;

class FactoryController extends Controller
{
    //Display a listing of the factories.
    public function index()
    {
        $factories = Factory::paginate(10);
        return view('factories.index', compact('factories'));
    }

    //Show the form for creating a new factory.
    public function create()
    {
        return view('factories.create');
    }

    //Store a newly created factory.
    public function store(Request $request)
    {
        $request->validate(Factory::$rules);
        Factory::create($request->all());
        return redirect()->route('factories.index')->with('success', 'Factory created successfully');
    }

    //Display the specified factory.
    public function show(Factory $factory)
    {
        return view('factories.show', compact('factory'));
    }

    //Show the form for editing the specified factory.
    public function edit(Factory $factory)
    {
        return view('factories.edit', compact('factory'));
    }

    //Update the specified factory.
    public function update(Request $request, Factory $factory)
    {
        $request->validate(Factory::$rules);
        $factory->update($request->all());
        return redirect()->route('factories.index')->with('success', 'Factory updated successfully');
    }

    //Remove the specified factory.
    public function destroy(Factory $factory)
    {
        $factory->delete();
        return redirect()->route('factories.index')->with('success', 'Factory deleted successfully');
    }
}