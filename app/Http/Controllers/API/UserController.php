<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modelos\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\CorreoMailJet;
use App\Mail\CorreoLogIn;
use App\Mail\CorreoLogAdmin;
use App\Mail\CorreoMostrarDatos;


class UserController extends Controller
{
    //crear usuario
    public function registrar(Request $request){
        $user['confirmationCode']=str_random(5);
        $request->validate([
            'name'=>'required',
            'edad'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'confirmationCode'=>$user['confirmationCode']
        ]);

        $user = new User();
        $email=new User();
        $email->email=$request->email;

        $user->name=$request->name;
        $user->edad=$request->edad;
        $user->email=$request->email;
        
        $user->password=Hash::make($request->password);

        if($user -> save())
            $mail=Mail::to($email)->send(new CorreoMailJet(), $user);
            return response()->json([$user],201);

        return abort(400,"Error al guardar el Registro");
    }
    //Verificar Correo
    public function verify($code){
        $user=User::where('confirmationCode',$code->first());
        
    }


    //Logueo de usuarios
    public function logIn(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email=new User();
        $email->email=$request->email;
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email|password' => ['Credenciales incorrectas...'],
            ]);
        }

        $token = $user->createToken($request->email, ['user:info'])->plainTextToken;
        $mail=Mail::to($email)->send(new CorreoLogIn());
        return response()->json(["token" => $token], 201);
    }


    //crear usuario Admin (esto no se hace)
    public function logAdmin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $email= new User();
        $email->email=$request->email;
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email|password' => ['Credenciales incorrectas...'],
            ]);
        }

        $token = $user->createToken($request->email, ['admin:admin'])->plainTextToken;
        $mail=Mail::to($email)->send(new CorreoLogAdmin());
        return response()->json(["token" => $token], 201);
    }

    //Muestra informacion segun tus Permisos
    public function mostrarDatos(Request $request){

        if($request->user()->tokenCan('admin:admin'))
        $mail=Mail::to('alhely.bar@gmail.com')->send(new CorreoMostrarDatos());
            return response()->json(["users"=>User::all()],200);

        if($request->user()->tokenCan('user:info'))
        $mail=Mail::to('alhely.bar@gmail.com')->send(new CorreoMostrarDatos());
            return response()->json(["perfil"=>$request->user()],200);

        return abort(401, "Scope invalido");
    }



    //Solo admin puede Borrar
    public function borrar(Request $request, $id){
        if($request->user()->tokenCan('admin:admin'))
            //$user=User::find($id);
           // $user->delete();
            User::destroy($id);
            return response()->json(['messeage' => 'Usuario eliminado correctamente'],200);

        return abort(401, "No tienes Permisos"); 
        

    }

    //Cambiar propiedades a Usuario
    public function actualizar(Request $request, $id){
        $user=User::find($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=$request->password;

        if($user -> save())
            return response()->json(["persona"=>$user],201);

        return response()->json(null,400);
    }


    
}
