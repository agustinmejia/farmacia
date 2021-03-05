<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoLote extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id', 'nro_lote', 'fecha_vencimiento'
    ];

    public function almacen(){
        return $this->hasMany('App\Models\SucursalProductoLote', 'producto_lote_id');
    }
}
