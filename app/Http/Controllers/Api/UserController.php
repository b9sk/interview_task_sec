<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserApiRequest;
use App\Models\User;

class UserController extends Controller
{
    function index(){
        return response()->json(User::paginate(20));
    }

    function show($id){
        return response()->json(User::find($id));
    }

    function create(UserApiRequest $request){
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    function update(UserApiRequest $request, $id){
        $user = User::find($id);
        $user->update($request->all());
        return response()->json($user);
    }

    function delete($id){
        User::destroy($id);
        return response()->json(null, 204);
    }
}
