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
    public function producto()
    {
        return $this->belongsTo('App\Models\Comercio\Producto', 'producto_id');
    }
}
