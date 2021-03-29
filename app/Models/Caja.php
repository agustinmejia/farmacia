<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nombre', 'monto_cierre', 'monto_real', 'estado', 'observaciones'];

    public function detalle(){
        return $this->hasMany(CajaDetalle::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
