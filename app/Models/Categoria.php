<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    //read route por slug
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // relaship 1:n category -> establecimiento

    public function establecimiento(){
       return  $this->hasMany(Establecimiento::class);
    }
}
