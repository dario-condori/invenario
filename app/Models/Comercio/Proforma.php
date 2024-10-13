<?php

namespace App\Models\Comercio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    use HasFactory;

    protected $table='proformas';

    public function productos()
    {
        return $this->hasMany('App\Models\Comercio\ProformaProductos', 'proforma_id');
    }

    public function comercios()
    {
        return $this->hasMany('App\Models\Comercio\Comercio', 'proforma_id');
    }
}
