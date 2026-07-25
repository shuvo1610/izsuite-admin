<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DestroyAdminProfileRequest;
use App\Http\Requests\Admin\UpdateAdminProfilePasswordRequest;
use App\Http\Requests\Admin\UpdateAdminProfileRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        try {
            return view('admin.profile.show', [
                'user' => auth()->user(),
            ]);

        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function update(UpdateAdminProfileRequest $request)
    {
        try {
            $user      = auth()->user();
            $validated = $request->validated();

            $user->update($validated);

            return back()->with('success', __('Profile updated successfully.'));

        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function updatePassword(UpdateAdminProfilePasswordRequest $request)
    {
        try {
            auth()->user()->update([
                'password' => Hash::make($request->password),
            ]);

            return back()->with('success', __('Password changed successfully.'));

        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function destroy(DestroyAdminProfileRequest $request)
    {
        try {
            $user = $request->user();

            if ($user->isSuperAdmin()) {
                return back()->with('error', __('The super admin account cannot be deleted.'));
            }

            auth()->logout();
            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', __('Your account has been deleted.'));

        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }
}
