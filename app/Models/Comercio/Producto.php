<?php

namespace App\Models\Comercio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    //--- para identificar el producto comercializado
    public function vueltas()
    {
        return $this->hasMany('App\Models\Comercio\Comercio', 'producto_id');
    }
}
