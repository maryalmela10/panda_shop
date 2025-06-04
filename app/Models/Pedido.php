<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';
    protected $fillable = [
        'usuario_id',
        'metodo_pago',
        'coste_envio',
        'direccion_envio',
        'fecha_pedido',
    ];

    protected $casts = [
        'fecha_pedido' => 'datetime',
    ];

    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'pedido_producto')
                    ->withPivot('cantidad', 'precio_producto'); // Relación muchos a muchos con pivot
    }
}
