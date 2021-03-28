<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_lote_id', 'compra_id', 'precio', 'descuento', 'cantidad'
    ];

    public function producto_lote(){
        return $this->belongsTo(ProductoLote::class,'producto_lote_id');
    }
}
