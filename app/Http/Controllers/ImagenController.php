<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use App\Models\Establecimiento;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImagenController extends Controller
{
    //
    public function store(Request $request){
        // read the image
        $ruta_imagen = $request->file('file')->store('establecimiento','public');
        // resize the image
        $imagen = Image::make(public_path("storage/{$ruta_imagen}"))->fit(800,450);
        $imagen->save();

        // save in BD
        Imagen::create([
            'id_establecimiento' => $request->uuid,
            'ruta_imagen' => $ruta_imagen
        ]);

        // return response with name route image
        $response = [
            'archivo' => $ruta_imagen
        ];

        return response()->json($response,200);
    }

    public function destroy(Request $request){
        $uuid = $request->get('uuid');
        $name_route = $request->get('imagen');
        $establecimiento = Establecimiento::where('uuid',$uuid)->first();

        $this->authorize('delete',$establecimiento);

        $path_imagen = '/public/'. $name_route;

        if(Storage::exists($path_imagen)) Storage::delete($path_imagen);

        // Imagen::where('ruta_imagen',$name_route)->delete();
        $imageFound = Imagen::where('ruta_imagen',$name_route)->firstOrFail();
        Imagen::destroy($imageFound->id);
        return response()->json(['response' => true],200);
    }
}
