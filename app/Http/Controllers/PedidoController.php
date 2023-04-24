<?php

namespace App\Http\Controllers;

use App\Http\Resources\PedidoCollection;
use App\Models\Pedido;
use App\Models\PedidoProducto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.               Controller de /api/pedidos
     */
    public function index()
    {
        //Pasamos la informacion de Pedidos. with('user') para que agregue el usuario. where('estado', 0) para que agregue todos los pedidos con el estado en 0 (osea que NO han sido completadas)
        return new PedidoCollection(Pedido::with('user')->with('productos')->where('estado', 0)->get());


        return 'Correctosss';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Almacenar los datos de una orden (pedido)
        $pedido = new Pedido;                       //Le decimos que el modelo de pedidos se prepare para recibir informacion
        $pedido->user_id = Auth::user()->id;        //Le decimos que en la columna de user_id que tome el valor de: el usuario autenticado.
        $pedido->total = $request->total;
        $pedido->save();


    //PedidoProducto table

        //Obtener el ID del pedido.    (Aprovechamos que tenemos la instancia del pedido solamente le especificamos el id)
        $id = $pedido->id;

        //Obtener los productos del pedido
        $productos = $request->productos;

        //Formatear un arreglo
        $pedido_producto = [];              //Creamos un arreglo nuevo para relacionar informacion

        foreach($productos as $producto)
        {
            $pedido_producto[] = [
                'pedido_id' =>  $id,
                'producto_id' => $producto['id'],
                'cantidad' => $producto['cantidad'],
                'created_at' => Carbon::now(),              //created_at y updated_at lo generamos nosotros. 
                'updated_at' => Carbon::now()               //Esto se debe a que utilizaremos un metodo llamado "insert" para insertar estos datos a la BD
            ];
        }

        //Almacenar en la BD
        PedidoProducto::insert($pedido_producto);           //Insertamos el arreglo de pedido_producto a la TABLA DE PedidoProducto.


        return [
            'message' => 'Tu pedido se realizo correctamente. Estara listo en unos minutos.'
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        $pedido->estado = 1;
        $pedido->save();

        //round model binding  -  Nos ayuda a entrar en el modelo de Pedido y hacerle la modificacion del estado a 1
        return [
            'pedido' => $pedido
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
