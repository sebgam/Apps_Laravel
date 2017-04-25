<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()  //------------listar contenido de base de datos----------
    {
        $users = User::all()->toArray();
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function store(Request $request) //------------------------alamacenar en base de datos-----
    {
        try {
            $user = new User([
                'name'=> $request->input('name'),
                'email'=> $request->input('email'),  //---------toma datos del form----------
                'password'=> bcrypt($request->input('password'))
            ]);

            $user->save();//--------guarda--------
            return response()->json(['status'=>true,'Great thanks'],200);//-------exito----------


        } catch (Exception $e) {
            Log::critical("could not store user: {$e->getCode()} , {$e->getLine()},{$e->getMessage()}");//------error-----------
            return response('semething bad',500);
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) //----------------------------mostrar un dato con $id--------------
    {
       try {
           $user= User::find($id); //--mostrar

        if (!$user) {
            return response()->json('this id doesnt exist', 404);
        }

        return response()->json($user,200);

       } catch (Exception $e) {
           
            Log::critical("could not store user: {$e->getCode()} , {$e->getLine()},{$e->getMessage()}");//------error-----------
            return response('semething bad',500);
       }
        



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function update(Request $request, $id) //--------actualizar dato $id---------------
    {
        try {
            $user= User::find($id);

            if(!$user){
                return response()->json('no se encuentra resultados',404);
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            return response()->json('User updated',200);


        } catch (Exception $e) {
            Log::critical("could not store user: {$e->getCode()} , {$e->getLine()},{$e->getMessage()}");//------error-----------
            return response('semething bad',500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) //-----------------eliminar dato $id------------------
    {
        try {

            $user= User::find($id);
            if (!$user) {
            return response()->json('this id doesnt exist', 404);
            }

            $user->delete();
            return response()->json('User deleted',200);

        } catch (Exception $e) {
             Log::critical("could not store user: {$e->getCode()} , {$e->getLine()},{$e->getMessage()}");//------error-----------
            return response('semething bad',500);
        }
    }
}
