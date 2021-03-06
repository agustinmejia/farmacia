<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SucursalProductoLote extends Model
{
    use HasFactory;

    protected $fillable = [
        'sucursal_id', 'producto_lote_id', 'precio', 'precio_mayor', 'descuento', 'stock'
    ];

    public function sucursal(){
        return $this->hasOne('App\Models\Sucursal', 'id');
    }

    public function lote(){
        return $this->belongsTo('App\Models\ProductoLote', 'producto_lote_id');
    }
}
