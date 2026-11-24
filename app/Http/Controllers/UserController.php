<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(12);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create', ['user' => new User()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180', 'unique:users,email'],
            'role' => ['required', Rule::in(['admin', 'personnel', 'requester'])],
            'office' => ['nullable', 'string', 'max:150'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('users.index')->with('success', 'User account created.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'personnel', 'requester'])],
            'office' => ['nullable', 'string', 'max:150'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);
        if (filled($data['password'] ?? null)) $data['password'] = Hash::make($data['password']);
        else unset($data['password']);
        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User account updated.');
    }

    public function destroy(User $user)
    {
        abort_if($user->id === auth()->id(), 422, 'You cannot delete your own account.');
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User account deleted.');
    }
}
