<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCompraDetalle extends Model
{
    use HasFactory;

    protected $table = 'orden_compra_detalles';

    protected $fillable = [
        'producto_id',
        'cantidad',
        'descuento',
        'subtotal',
        'ordenCompra_id'
    ];
}