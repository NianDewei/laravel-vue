<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Categoria;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class CategoriaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::create(
            [
                'nombre' => 'Restaurant',
                'slug'   => Str::slug('Restaurant')
            ],

        );

        Categoria::create(
            [
                'nombre' => 'Café',
                'slug'   => Str::slug('Café')
            ]
        );

        Categoria::create(
            [
                'nombre' => 'Jugueria',
                'slug'   => Str::slug('Jugueria')
            ]
        );
        Categoria::create(
            [
                'nombre' => 'Bares',
                'slug'   => Str::slug('Bares')
            ]
        );
        Categoria::create(
            [
                'nombre' => 'Hoteles',
                'slug'   => Str::slug('Hoteles')
            ]
        );
    }
}
