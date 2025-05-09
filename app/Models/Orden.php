<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;
    protected $table = 'ordenes';

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
