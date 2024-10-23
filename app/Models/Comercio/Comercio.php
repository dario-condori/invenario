<?php

namespace App\Models\Comercio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comercio extends Model
{
    use HasFactory;

    protected $table = 'comercio';

    //--- para identificar el personal participante
    public function personal()
    {
        return $this->belongsTo('App\Models\Admin\Personal', 'personal_id');
    }

    //--- para identificar el producto
    public function comercioProductos()
    {
        return $this->hasMany('App\Models\Comercio\ComercioProductos', 'comercio_id');
    }

    //--- para identificar el vehiculo que transporta
    public function vehiculo()
    {
        return $this->belongsTo('App\Models\Admin\Vehiculo', 'vehiculo_id');
    }

    //--- para identificar la proforma
    public function proforma()
    {
        return $this->belongsTo('App\Models\Comercio\Proforma', 'proforma_id');
    }
}
