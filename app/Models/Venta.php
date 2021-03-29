<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'cliente_id', 'sucursal_id', 'observaciones'
    ];

    public function detalle(){
        return $this->hasMany(VentaDetalle::class);
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
