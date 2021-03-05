<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SucursalProductoLote extends Model
{
    use HasFactory;

    protected $fillable = [
        'sucursal_id', 'producto_lote_id', 'precio', 'stock'
    ];

    public function sucursal(){
        return $this->hasOne('App\Models\Sucursal', 'id');
    }
}
