<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\User;
use App\Http\Controllers\Controller as Controller;

class UserController extends Controller
{    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUser(Request $request)
    {
        //
        $id = $request->input('id');
        $fmt = $request->input('fmt');
        if($id){
            $users = User::find($id);
        }else{
            $users = User::all();
        }
        if($fmt){
            return response(array(
                'status' => 'success',
                'users' => $users), 200)->header('Content-Type', 'text/plain');
        }else{
        return Response::json(array(
            'status' => 'success',
            'users' => $users->toArray()),
            200
            );
        }
        
    }
}