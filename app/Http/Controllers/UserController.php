<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all(); //[cite: 1, 2]
        return view('admin.user.index', compact('users')); //[cite: 1, 2]
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create'); //[cite: 1, 2]
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100', //[cite: 1, 2]
            'email' => 'required|email|unique:users,email', //[cite: 1, 2]
            'password' => 'required|min:8|confirmed', //[cite: 1, 2]
        ]);

        User::create([
            'name' => $request->name, //[cite: 1, 2]
            'email' => $request->email, //[cite: 1, 2]
            'password' => Hash::make($request->password), //[cite: 1, 2]
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id); //[cite: 1, 2]
        return view('admin.user.edit', compact('user')); //[cite: 1, 2]
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id); //[cite: 1, 2]

        $request->validate([
            'name' => 'required|string|max:100', //[cite: 1, 2]
            'email' => 'required|email|unique:users,email,' . $id, //[cite: 1, 2]
            'password' => 'nullable|min:8|confirmed', //[cite: 1, 2]
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password); //[cite: 1, 2]
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id); //[cite: 1, 2]
        $user->delete(); //[cite: 1, 2]

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus!');
    }
}