<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAlmacen extends Model
{
    use HasFactory;

    protected $table = 'tipo_almacen';

    //--- para listar los comercios de productos
    public function almacenes()
    {
        return $this->hasMany('App\Models\Comercio\Almacen', 'tipo_almacen_id');
    }
}
