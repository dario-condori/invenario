<?php

namespace App\Models\Comercio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    use HasFactory;

    protected $table='proformas';

    public function comercios()
    {
        return $this->belongsTo('App\Models\Comercio\Comercio', 'proforma_id');
    }
}
