<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class UserController extends Controller
{
    // GET /users
    public function index()
    {
        $users = User::latest()->get();
        return view('pages.users', compact('users'));
    }

    // POST /users — Add new user
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:user,admin',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.required'  => 'សូម​ បញ្ចូល​ ឈ្មោះ',
            'email.required' => 'សូម​ បញ្ចូល​ Email',
            'email.unique'   => 'Email​ នេះ​ ត្រូវ​ បាន​ ប្រើ​ ហើយ',
            'password.confirmed' => 'Password​ មិន​ ត្រូវ​ គ្នា',
            'password.min'       => 'Password​ ≥ 8​ តួ',
        ]);

        User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'role'              => $request->role,
            'password'          => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User "' . $request->name . '" ត្រូវ​ បាន​ Add ដោយ​ ជោគជ័យ! ✅');
    }

    // DELETE /users/{id}
    public function destroy($id)
    {
        if (Auth::id() == $id) {
            return redirect()->route('users.index')
                ->with('error', 'អ្នក​ មិន​ អាច​ លុប​ គណនី​ ខ្លួន​ ឯង!');
        }

        $user = User::findOrFail($id);
        $name = $user->name;
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User "' . $name . '" ត្រូវ​ បាន​ លុប​ ដោយ​ ជោគជ័យ! 🗑️');
    }
}