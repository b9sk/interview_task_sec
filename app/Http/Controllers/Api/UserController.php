<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserApiRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    function index(Request $request) {
        $query = User::query();

        // поиск по имени или части имени
        if ($request->input('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // сортировка по имени, где только 2 параметра asc и desc
        if (in_array($request->input('order'), ['asc', 'desc'])) {
            $query->orderBy('name', $request->input('order'));
        }

        return response()->json($query->paginate(20));
    }

    function show($id){
        try {
            $user = User::findOrFail($id);
            return response()->json($user);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse();
        }
    }

    function store(UserApiRequest $request){
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    function update(UserApiRequest $request, $id){
        try {
            $user = User::findOrFail($id);
            $user->update($request->all());
            return response()->json($user);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse();
        }
    }

    function destroy($id){
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
