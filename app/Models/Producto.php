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

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
