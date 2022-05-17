<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\Establecimiento;
use App\Models\Imagen;

class ApiController extends Controller
{
    //Method for get all categorys
    public function categorys()
    {
        $categorys = Categoria::select('id','nombre','slug')->get();
        // $categorys = Categoria::get(['id','nombre','slug']);
        return response()->json($categorys);
    }

    // see the specific category
    public function category(Categoria $categoria)
    {
        $establecimiento = Establecimiento::with('categoria')->where('categoria_id',$categoria->id)->take(3)->get();
        return response()->json($establecimiento);
    }

    public function establecimientos()
    {
        $establecimiento = Establecimiento::with('categoria')->get();
        return response()->json($establecimiento);
    }

    public function establecimiento(Establecimiento $establecimiento){
        $imagenes = Imagen::where('id_establecimiento',$establecimiento->uuid)->get();
        $establecimiento->imagenes = $imagenes;
        return response()->json($establecimiento);
    }
}
