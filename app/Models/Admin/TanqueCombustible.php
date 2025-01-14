<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanqueCombustible extends Model
{
    use HasFactory;

    protected $table = 'tanque_combustible';

    //--- para identificar que usuario lo creo
    public function usuario()
    {
        return $this->belongsTo('App\Models\User', 'usuario_id');
    }

    //--- para identificar combustible del vehiculo
    public function vehiculo()
    {
        return $this->belongsTo('App\Models\Admin\Vehiculo', 'vehiculo_id');
    }
}
