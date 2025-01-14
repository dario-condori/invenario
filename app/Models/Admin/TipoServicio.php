<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    use HasFactory;

    protected $table = 'tipo_servicio';

    //--- para listar los comercios de productos
    public function mantenimientos()
    {
        return $this->hasMany('App\Models\Admin\Mantenimiento', 'tipo_servicio_id');
    }
}
