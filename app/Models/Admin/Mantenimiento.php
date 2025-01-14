<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    use HasFactory;

    protected $table = 'mantenimiento';

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

    //--- para identificar tipo de servicio
    public function tipoServicio()
    {
        return $this->belongsTo('App\Models\Admin\TipoServicio', 'tipo_servicio_id');
    }
}
