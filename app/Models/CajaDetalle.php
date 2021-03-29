<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaDetalle extends Model
{
    use HasFactory;

    protected $fillable = ['caja_id', 'detalle', 'monto', 'tipo', 'venta_id', 'compra_id'];
}
