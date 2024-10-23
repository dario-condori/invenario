<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoOrigen extends Model
{
    use HasFactory;

    protected $table = 'tipo_origen';

    //--- para listar los comercios de productos
    public function comercioProductos()
    {
        return $this->hasMany('App\Models\Comercio\ComercioProductos', 'tipo_origen_id');
    }
}
