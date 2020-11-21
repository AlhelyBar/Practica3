<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table='comentarios';

    public function user (){
    return $this -> belongsTo('App\Modelos\User','persona_id','id');
    
    }
    public function producto (){
    return $this -> belongsTo('App\Modelos\Producto','producto_id','id');
    
    }
}
