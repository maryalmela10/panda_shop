<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'telefono' => ['required', 'string', 'max:30', 'regex:/^\+?\d{9,15}$/'],
            'address' => ['required', 'string', 'min:10', 'regex:/^(Calle|Avenida|Avda\.?|Plaza|Paseo|Pza\.?|Camino|Carretera)\s+[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]+,\s*\d+,\s*\d{5}$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'address.required' => 'La dirección de envío es obligatoria.',
            'address.regex' => 'La dirección debe tener el formato: TipoVía Nombre, número, código postal (ej: Calle Alcalá, 12, 28027).',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard.index', absolute: false))->with('success', '¡Registro exitoso! Se te ha enviado un correo de verificación a tu email');;

    }
}
