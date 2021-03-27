<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'proveedore_id', 'descuento', 'observaciones'
    ];

    public function detalle(){
        return $this->hasMany(CompraDetalle::class);
    }

    public function proveedor(){
        return $this->belongsTo(Proveedore::class,'proveedore_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
