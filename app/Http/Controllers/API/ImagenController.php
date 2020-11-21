<?php

namespace App\Http\Controllers\API;

use App\Modelos\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\Correo;

class ImagenController extends Controller
{
   public function guardarFoto(Request $request){

    $entrada=$request->all();
    if($request->user()->tokenCan('admin:admin'))
    {
        if($archivo=$request->hasFile('file'))
        {
            $path = Storage::put($este='documentos/imagenPerfil',$request->file);
            $nombre=$request->file('file')->getClientOriginalName();
            $extension=$request->file('file')->extension();
            //$este['imagenes'];
            settype($nombre,"string");
            $user=$nombre;
            //$user->save();
            //user::create($este);
        return response()->json(["path"=>$path],201);
        }
    }
}
}
    


        /*$email=new User();
        if($request->user()->tokenCan('admin:admin')){
            $email->email=$request->email;
            if($request->hasFile('file')){
                $extension = $request->file('file')->extension();
                $path = Storage::put('documentos/imagenPerfil{{email}}',$request->file);
                return response()->json(["path"=>$path],201);
            }
        }



//$mail=Mail::to('alhely.bar@gmail.com')->send(new CorreoMostrarDatos());
            //return response()->json(["perfil"=>$request->user()],200);
            */