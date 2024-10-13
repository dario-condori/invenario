<?php

namespace App\Models\Comercio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProformaProductos extends Model
{
    use HasFactory;

    protected $table = 'proforma_productos';

    public function producto()
    {
        return $this->belongsTo('App\Models\Comercio\Producto', 'producto_id');
    }
}
