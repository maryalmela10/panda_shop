<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'imagen_url', // o 'imagen' si subes archivos
        'disponible',
        'stock',
        'categoria_id',
        'fecha_reposicion'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function ordenes()
    {
        return $this->belongsToMany(Orden::class, 'orden_producto')
                    ->withPivot('cantidad', 'precio');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'producto_id');
    }

    // Accesor para el promedio
    public function getReviewPromedio()
    {
        return round($this->reviews()->avg('estrellas'), 1);
    }
}
