<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Poli;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $polis = Poli::all(); // Ambil semua data poli

        return view('profile.edit', [
            'user' => $user,
            'polis' => $polis,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $rules = [
            // validasi field lain...
        ];

        if ($user->role === 'dokter') {
            $rules['id_poli'] = 'required|exists:polis,id';
        }

        $validated = $request->validate($rules);

        // Update field lain...
        if ($user->role === 'dokter') {
            $user->id_poli = $validated['id_poli'];
        }

        $user->save();

        return redirect()->back()->with('status', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
