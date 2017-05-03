<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{

    public function __construct(){
        $this->middleware(['jwt.auth', 'jwt.refresh']); 
    }
    
    public function index(){
        return User::all();
    }

    public function paginated($page=1){
        $limit=1;
        return response()->json([
            "count"=>User::count(),
            "data"=>User::skip(($page-1)*$limit)->take($limit)->get()->toArray()
            ]);
    }

    public function store($request){
        $user=new User;
        $inserted=$user->create($request->input());
        return response()->json([
            "res"=>"El usuario con id {$inserted->id} ha sido guardado"
        ]);
    }

    public function show($id){
         return User::find($id) ?: [];
    }

    public function update(Request $request,$id){
        $user=User::find($id);
        $user->fill($request->all())->save();
        return response()->json([
            "res"=>"Usuario con el id {$id} actualizado"
        ]);
    }

    public function destroy($id){
        User::destroy($id);
        return response()->json([
            "res"=>"Usuario con el id {$id} eliminado"
        ]);
    }
}
