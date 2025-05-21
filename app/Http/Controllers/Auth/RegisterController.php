<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerifyEmail;

class RegisterController extends Controller
{
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['verify', 'showVerificationNotice', 'resendVerificationEmail']);
    }

    /**
     * Mostrar el formulario de registro.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Manejar el registro de un nuevo usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Crear el usuario con un token de verificación
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verification_token' => Str::random(60),
            'email_verification_token_expires_at' => Carbon::now()->addHours(24),
            'email_verified_at' => null,
        ]);

        // Enviar el correo de verificación
        Mail::to($user->email)->send(new VerifyEmail($user));

        // Disparar evento de registro
        event(new Registered($user));

        return redirect()->route('verification.notice')
            ->with('success', 'Te has registrado correctamente. Por favor, verifica tu correo electrónico.');
    }

    /**
     * Mostrar la vista de "verifica tu correo electrónico".
     *
     * @return \Illuminate\View\View
     */
    public function showVerificationNotice()
    {
        return view('auth.verify');
    }

    /**
     * Verificar el correo electrónico del usuario.
     *
     * @param  string  $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify($token)
    {
        // Buscar usuario por token
        $user = User::where('email_verification_token', $token)
                ->where('email_verification_token_expires_at', '>', Carbon::now())
                ->first();

        if (!$user) {
            return redirect()->route('verification.notice')
                    ->with('error', 'El enlace de verificación no es válido o ha expirado.');
        }

        // Marcar como verificado
        $user->email_verified_at = Carbon::now();
        $user->email_verification_token = null;
        $user->email_verification_token_expires_at = null;
        $user->save();

        // Iniciar sesión automáticamente
        Auth::login($user);

        return redirect()->route('home')
                ->with('success', '¡Tu correo electrónico ha sido verificado correctamente!');
    }

    /**
     * Reenviar el correo de verificación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendVerificationEmail(Request $request)
    {
        // Si el usuario ya está verificado
        if ($request->user() && $request->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        // Obtener el usuario actual o por email
        if ($request->user()) {
            $user = $request->user();
        } else {
            $request->validate(['email' => 'required|email']);
            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                return back()->with('error', 'No se encontró un usuario con ese correo electrónico.');
            }
        }

        // Generar nuevo token
        $user->email_verification_token = Str::random(60);
        $user->email_verification_token_expires_at = Carbon::now()->addHours(24);
        $user->save();

        // Enviar correo
        Mail::to($user->email)->send(new VerifyEmail($user));

        return back()->with('success', 'Se ha enviado un nuevo enlace de verificación a tu correo electrónico.');
    }
}