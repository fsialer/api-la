<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;

class AuthenticationController extends Controller
{
    public function __construct(){
        $this->middleware('jwt.auth', ['except' => ['login', 'signup']]);
    }

    public function login(Request $request){
      
         try
        {
            $user = User::where(['email' => $request['email'],'password'=>$request['password']])->first(['email','id','name']);

            if($user)
            {
                if(!$token = JWTAuth::fromUser($user, ['email' => $user->email, 'id' => $user->id, 'name'=> $user->name]))
                { 
                    return response()->json(['error' => 'invalid_credentials'], 401);
                }
            }
            else
            {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        }
        catch(JWTException $e)
        {
            return response()->json(['error'  => 'no se ha podido crear el token' ], 500);
        }

        return response()->json(compact('token'));
    }

    public function signup(Request $request){
       $user = User::where(['email' => $request["email"]])->exists();
        if($user){
            return response()->json(['msg' => "El usuario con email {$request->email} ya existe"], 400);
        }
        $user=new User;
        /*$request["password"]=bcrypt($request["password"]);*/
        $user->create($request->input());
        return response()->json(['msg'=>'Usuario registrado correctamente.']);
    }

}
