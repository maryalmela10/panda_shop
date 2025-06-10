<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Validación adicional para address y telefono
        $validator = Validator::make($request->all(), [
            'address' => [
                'nullable',
                'string',
                'regex:/^C\/[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+,\s*\d+$/'
            ],
            'telefono' => [
                'nullable',
                'regex:/^\d{9}$/'
            ],
        ], [
            'address.regex' => 'La dirección debe tener el formato: C/NombreCalle, número (ejemplo: C/Alcalá, 12).',
            'telefono.regex' => 'El teléfono debe tener 9 dígitos numéricos.',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validación estándar definida en ProfileUpdateRequest
        $validated = $request->validated();

        $emailChanged = $validated['email'] !== $user->email;

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'address' => $request->input('address'),
            'telefono' => $request->input('telefono'),
        ]);

        if ($emailChanged) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Enviar correo de verificación si se cambió el email
        if ($emailChanged) {
            $user->sendEmailVerificationNotification();
        }

        return Redirect::route('dashboard.profile')->with('success', 'Perfil editado con éxito. Si cambiaste tu correo, revisa tu bandeja para verificarlo.');
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

        return Redirect::to('/')->with('success', 'Usuario eliminado con éxito');
    }
}
