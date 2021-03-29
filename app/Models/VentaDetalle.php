<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id', 'sucursal_producto_lote_id', 'precio', 'cantidad'
    ];

    public function sucursal_producto(){
        return $this->belongsTo(SucursalProductoLote::class,'sucursal_producto_lote_id');
    }
}
