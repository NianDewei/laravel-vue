<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Categoria;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Establecimiento;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EstablecimientoRequest;
use App\Http\Requests\EstablecimientoUpdateRequest;
use Illuminate\Auth\Middleware\Authorize;

class EstablecimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::pluck('nombre', 'id');
        return view('establecimiento.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EstablecimientoRequest $request)
    {

        // save the image
        $route_image = $request->validated()['imagen_principal']->store('principales', 'public');
        // resize the image
        $image = Image::make(public_path("storage/{$route_image}"))->fit(800, 600);
        $image->save();

        $params = [
            'request'   => $request->validated(),
            'name_key'  => 'imagen_principal',
            'data_key'  => $route_image
        ];

        // return data
        $data = changeKeyReturnRequest($params);

        // send to BD for store
        auth()->user()->establecimiento()->create($data);

        return back()->with('success', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function show(Establecimiento $establecimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Establecimiento $establecimiento)
    {
        $this->authorize('view', $establecimiento);

        $categorias = Categoria::pluck('nombre', 'id');
        $galeria = Imagen::where('id_establecimiento', $establecimiento->uuid)->pluck('ruta_imagen', 'id');

        return view('establecimiento.edit', compact('establecimiento', 'categorias', 'galeria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function update(EstablecimientoUpdateRequest $request, Establecimiento $establecimiento)
    {
        $this->authorize('update', $establecimiento);
        $data = $request->validated();

        $imagen_principal = Arr::exists($data, 'imagen_principal');
        $imagen_es_accesible = Arr::accessible($data, 'imagen_principal');
        $imagen_principal_old = $request->imagen_principal_actual;

        if ($imagen_principal && $imagen_es_accesible) {
            // eliminar imagen anterior
            $name_route = $imagen_principal_old;
            $esta_imagen = '/public/' . $name_route;

            if (Storage::exists($esta_imagen)) Storage::delete($esta_imagen);

            // guardar imagen reciente
            $route_image = $data['imagen_principal']->store('principales', 'public');
            // resize the image
            $image = Image::make(public_path("storage/{$route_image}"))->fit(800, 600);
            $image->save();

            $params = [
                'request'   => $request->validated(),
                'name_key'  => 'imagen_principal',
                'data_key'  => $route_image
            ];
            // mutamos nueva data para enviar a la BD
            $data = changeKeyReturnRequest($params);
        }

        // actualizamos los datos
        Establecimiento::where('id', $establecimiento->id)->update($data);
        //feedback al front End
        return back()->with('update', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Establecimiento $establecimiento)
    {
        //
    }
}
