<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserApiRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    function index(){
        return response()->json(User::paginate(20));
    }

    function show($id){
        try {
            $user = User::findOrFail($id);
            return response()->json($user);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse();
        }
    }

    function create(UserApiRequest $request){
        $user = User::create($request->all());
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return response()->json($user, 201);
    }

    function update(UserApiRequest $request, $id){
        try {
            $user = User::findOrFail($id);
            $user->update($request->all());

            if ($request->input('password')) {
                $user->password = bcrypt($request->input('password'));
            }

            $user->save();

            return response()->json($user);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse();
        }
    }

    function delete($id){
        try {
            User::findOrFail($id);
            User::destroy($id);

            return response(null, 204);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse();
        }
    }

    private function notFoundResponse() {
        return response()->json(['error' => 'User not found'], 404);
    }
}
