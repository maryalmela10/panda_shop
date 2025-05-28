<?php

namespace App\Mail;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoResumenMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido;
    public $cart;
    public $totalCost;

    public function __construct(Pedido $pedido, $cart, $totalCost)
    {
        $this->pedido = $pedido;
        $this->cart = $cart;
        $this->totalCost = $totalCost;
    }

    public function build()
    {
        return $this->subject('Resumen de tu pedido')
            ->view('emails.pedido_resumen');
    }
}
