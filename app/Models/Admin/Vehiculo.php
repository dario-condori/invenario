<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = 'vehiculos';

    //--- para identificar que usuario lo creo
    public function usuario()
    {
        return $this->belongsTo('App\Models\User', 'usuario_id');
    }

    //--- para listar cargado de combustible
    public function cargaCombustible()
    {
        return $this->hasMany('App\Models\Admin\Combustible', 'vehiculo_id');
    }
}
