<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoLote extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id', 'nro_lote', 'codigo_barras', 'fecha_vencimiento'
    ];

    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }

    public function almacen(){
        return $this->hasMany('App\Models\SucursalProductoLote', 'producto_lote_id');
    }
}
