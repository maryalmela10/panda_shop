<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categorias';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen' // o 'imagen_url' según el nombre de tu campo
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }
}
