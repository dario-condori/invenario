<?php

namespace App\Models\Comercio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacen';

    //--- para identificar el producto comercializado
    public function tipoAlmacen()
    {
        return $this->belongsTo('App\Models\Admin\TipoAlmacen', 'tipo_almacen_id');
    }
}
