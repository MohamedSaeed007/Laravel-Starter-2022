<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;
use Brian2694\Toastr\Facades\Toastr;

class ProfileController extends Controller
{
    public function show()
    {
        return view('auth.profile');
    }

    public function update(ProfileUpdateRequest $request)
    {
        if ($request->photo) {
            if(auth()->user()->hasMedia()){
                auth()->user()->getFirstMedia()->delete();
            }
            auth()->user()->addMedia($request->photo)->toMediaCollection();
        }
        if ($request->password) {
            auth()->user()->update(['password' => Hash::make($request->password)]);
        }

        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        Toastr::success('Profile Updated Successfully', 'Success', ["positionClass" => "toast-top-right"]);

        return redirect()->back()->with('success', 'Profile updated.');
    }
}
