<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Establecimiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'categoria_id',
        'imagen_principal',
        'direccion',
        'cuadra',
        'lat',
        'lng',
        'telefono',
        'descripcion',
        'apertura',
        'cierre',
        'uuid',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function apertura(): Attribute
    {
        return new Attribute(

            get: fn ($apertura) => Carbon::create($apertura)->format('h:i'),
            // set: fn ($apertura) => Carbon::create($apertura)->format('h:i'),

        );
    }

    public function cierre(): Attribute
    {
        return new Attribute(

            get: fn ($cierre) => Carbon::create($cierre)->format('h:i'),
            // set: fn ($cierre) => Carbon::create($cierre)->format('h:i'),

        );
    }
}
