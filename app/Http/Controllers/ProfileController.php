<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        return view('pages.profile', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'  => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'bio'   => 'nullable|string|max:500',
        ], ['name.required' => 'សូមបញ្ចូលឈ្មោះ']);

        $user->name  = $request->name;
        $user->phone = $request->phone;
        $user->bio   = $request->bio;
        $user->save();

        return redirect()->route('profile')->with('success', 'ព័ត៌មាន​ ត្រូវ​ បាន​ Update! ✅');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate(['photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048']);
        $user = Auth::user();
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
        $path = $request->file('photo')->store('profile-photos', 'public');
        $user->profile_photo_path = $path;
        $user->save();
        return redirect()->route('profile')->with('success', 'រូប​ Profile​ ត្រូវ​ បាន​ ប្ដូរ! 📸');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'សូម​បញ្ចូល​ Password​ ចាស់',
            'password.confirmed'        => 'Password​ មិន​ ត្រូវ​ គ្នា',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password​ ចាស់​ មិន​ ត្រឹម​ ត្រូវ']);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('profile')->with('success', 'Password​ ត្រូវ​ បាន​ ប្ដូរ! 🔐');
    }
}