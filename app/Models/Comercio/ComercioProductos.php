<?php

namespace App\Models\Comercio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComercioProductos extends Model
{
    use HasFactory;

    protected $table = 'comercio_productos';

    public function producto()
    {
        return $this->belongsTo('App\Models\Comercio\Producto', 'producto_id');
    }

    //---hay en almacen
    public function almacen()
    {
        return $this->hasMany('App\Models\Comercio\Almacen', 'comercio_productos_id');
    }
}
