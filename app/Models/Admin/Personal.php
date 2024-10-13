<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'personal';

    //--- para identificar que usuario lo creo
    public function usuario()
    {
        return $this->belongsTo('App\Models\User', 'usuario_id');
    }

    //--- para listar los comercios realizados
    public function comercializacion()
    {
        return $this->hasMany('App\Models\Comercio\Comercio', 'personal_id');
    }
}
