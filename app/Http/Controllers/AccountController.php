<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        $accounts = Account::with(['paymentMethods', 'documents'])->paginate(10);
        return view('accounts.index', compact('accounts'));
    }

    //Show the form for creating a new resource.
    public function create()
    {
        return view('accounts.create');
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:account,username',
            'email' => 'required|email|unique:account,email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'password' => 'required|string|min:6|confirmed'
        ]);

        Account::create($validated);

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Account created successfully');
    }

    //Display the specified resource.
    public function show(string $id)
    {
        $account = Account::with(['paymentMethods', 'documents'])
            ->findOrFail($id);
        return view('accounts.show', compact('account'));
    }

    //Show the form for editing the specified resource.
    public function edit(string $id)
    {
        $account = Account::findOrFail($id);
        return view('accounts.edit', compact('account'));
    }

    //Update the specified resource in storage.
    public function update(Request $request, string $id)
    {
        $account = Account::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:account,username,'.$id,
            'email' => 'required|email|unique:account,email,'.$id,
            'phone' => 'required|string',
            'address' => 'required|string',
            'password' => 'nullable|string|min:6|confirmed'
        ]);

        // Hanya update password jika ada input password baru
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $account->update($validated);

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Account updated successfully');
    }

    //Remove the specified resource from storage.
    public function destroy(string $id)
    {
        $account = Account::findOrFail($id);
        $account->delete();

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Account deleted successfully');
    }
}