<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    public function user()
    {
        //Le decimos que en la tabla PEDIDOS la columna de USER pertenece al modelo de User
        return $this->belongsTo(User::class);
    }

    public function productos()
    {
        //Le decimos que Pedido tiene una relacion de muchos a muchos con Producto y esa relacion se enceuntra en la tabla de "pedido_productos"
        return $this->belongsToMany(Producto::class, 'pedido_productos')->withPivot('cantidad');
    }

}
