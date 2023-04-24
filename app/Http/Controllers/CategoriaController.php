<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoriaCollection;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    //
    public function index(){
        
        //Manera de retornar una respuesta JSON (bien pero mejor usando Resource para poder decidir que si y que no queremos pasar.)
        //return response()->json(['categorias=> Categoria::all()]);


        //Manera de retornar una respuesta JSON (Recomendada)
        return new CategoriaCollection(Categoria::all());
    }
}
