<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:100',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:2000',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'body' => $validated['message'], // No uses 'message' en la vista
        ];

        Mail::send('emails.contact', $data, function ($mail) use ($data) {
            $mail->to('test@example.com')
                ->replyTo($data['email'], $data['name'])
                ->subject('[Contacto] ' . $data['subject']);
        });

        return back()->with('success', '¡Mensaje enviado! Nos pondremos en contacto contigo pronto.');
    }
}
