@extends('layouts.app')
@section('style-css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder/dist/esri-leaflet-geocoder.css" />
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection
@section('content')
    <div class="container">
        <h1 class="text-center mt-4 fs-2"> Registrar Establecimiento</h1>
        <div class="mt-3 row justify-content-center">
            <form id="form-establecimiento" action="{{ route('establecimiento.store') }}"
                class="col-md-9 col-xs-12 card card-body p-5" method="POST" enctype="multipart/form-data">
                @csrf
                <fieldset class="border p-4 mb-3">
                    <legend class="text-primary">| Información</legend>

                    <div class="form-group mb-3">
                        <label for="nombre"> Nombre Establecimiento</label>
                        <input id="nombre" type="text" name="nombre"
                            class="form-control @error('nombre') is-invalid @enderror" placeholder="Ingrese el nombre."
                            value="{{ old('nombre') }}">
                        @error('nombre')
                            <div class="invalid-feedback">
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="categoria_id"> Categoría</label>
                        <select name="categoria_id" id="categoria"
                            class="form-control @error('categoria_id') is-invalid @enderror">
                            <option disabled selected value=""> -- Seleccione --</option>
                            @forelse ($categorias as $key => $categoria)
                                <option {{ old('categoria_id') == $key ? 'selected' : '' }} value="{{ $key }}">
                                    {{ $categoria }}</option>
                            @empty
                                <option value="">-- Sin categorias --</option>
                            @endforelse
                        </select>
                        @error('categoria_id')
                            <div class="invalid-feedback">
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="imagen_principal">Imagen Principal</label>
                        <input id="imagen_principal" type="file"
                            class="form-control @error('imagen_principal') is-invalid @enderror" name="imagen_principal"
                            value="{{ old('imagen_principal') }}">
                        @error('imagen_principal')
                            <div class="invalid-feedback">
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                </fieldset>

                <fieldset class="border p-4 mb-3">
                    <legend class="text-primary">| Ubicación</legend>

                    <div class="form-group mb-4">
                        <label for="b-direccion"> Dirección:</label>
                        <input id="b-direccion" type="text" class="form-control" placeholder="Calle / Avenida">

                        <div class="bg-warning mt-2 p-2 rounded-3 d-none">
                            <span class="ms-1">No hay restulados.</span>
                        </div>
                        {{-- <select class="form-select mt-2 text-center" id="search-results">
                            <option value="[-132132132,4564654654]">Test 01 </option>
                            <option value="[-132132132,4564654654]">Test 02 </option>
                            <option value="[-132132132,4564654654]">Test 03 </option>
                        </select> --}}
                        <p class="text-secondary mt-3 mb-3 text-center">
                            El asistente colocará una dirección estimada, mueve el PIN en el lugar correcto
                        </p>
                    </div>

                    <div class="form-group mb-4">
                        <div id="mapa" style="height:400px;" class="rounded-3 shadow">

                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="direccion">Dirección</label>
                        <input id="direccion" type="text" class="form-control @error('direccion') is-invalid @enderror"
                            placeholder="Ingrese el dirección" name="direccion" value="{{ old('direccion') }}">
                        @error('direccion')
                            <div class="invalid-feedback">
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="cuadra">Cuadra</label>
                        <input id="cuadra" type="text" class="form-control @error('cuadra') is-invalid @enderror"
                            placeholder="Ingrese la cuadra" name="cuadra" value="{{ old('cuadra') }}">
                        @error('cuadra')
                            <div class="invalid-feedback">
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <input type="hidden" id="lat" name="lat" value="{{ old('lat') }}">
                    <input type="hidden" id="lng" name="lng" value="{{ old('lng') }}">

                </fieldset>

                <fieldset class="border p-4 mb-3">
                    <legend class="text-primary">| Información Establecimiento:</legend>

                    <div class="form-group mb-3">
                        <label for="telefono">Télefono</label>
                        <input id="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror"
                            placeholder="Télefono del Establecimiento" name="telefono" value="{{ old('telefono') }}">
                        @error('telefono')
                            <div class="invalid-feedback">
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" type="text" class="form-control @error('descripcion') is-invalid @enderror"
                            placeholder="Télefono del Establecimiento" name="descripcion"> {{ old('descripcion') }}
                                        </textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="apertura">Hora Apertura</label>
                        <input id="apertura" type="time" class="form-control @error('apertura') is-invalid @enderror"
                            name="apertura" value="{{ old('apertura') }}">
                        @error('apertura')
                            <div class="invalid-feedback">
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="cierre">Hora Cierre</label>
                        <input id="cierre" type="time" class="form-control @error('cierre') is-invalid @enderror"
                            name="cierre" value="{{ old('cierre') }}">
                        @error('cierre')
                            <div class="invalid-feedback">
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                </fieldset>

                <fieldset class="border p-4 mb-3">
                    <legend class="text-primary"> Galeria:</legend>
                    <div class="form-group">
                        <div id="dropzone" class="dropzone form-control"></div>
                    </div>
                </fieldset>

                <input type="hidden" id="uuid" name="uuid" value="{{ Str::uuid()->toString() }}">
                <input type="submit" class="btn btn-primary mt-3 d-block" value="Registrar Establecimiento">

            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
    {{-- geocoder --}}
    <script src="https://unpkg.com/esri-leaflet" defer></script>
    <script src="https://unpkg.com/esri-leaflet-geocoder" defer></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js" defer></script>
    {{-- scripts personal --}}
    <script src="{{ asset('/js/maps.js') }}"></script>
    <script src="{{ asset('/js/dropzone.js') }}"></script>
@endsection
