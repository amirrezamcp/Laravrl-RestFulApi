<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\User\UserDetailsApiResource;
use App\Http\Resources\Admin\User\UsersListApiResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::paginate(15);

        return UsersListApiResource::collection($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'min:1', 'max:255'],
            'last_name' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:1', 'max:255'],
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return response()->json([
            'data' => $user,
            'message' => "Create User: $user->first_name. Successfully!"
        ]);

        return $this->apiResponse(message: "Create User: $user->first_name. Successfully!", data: $user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserDetailsApiResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'min:1', 'max:255'],
            'last_name' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'email'],
            'password' => ['nullable', 'string', 'min:1', 'max:255'],
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        if(isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);

        return $this->apiResponse(message: "Update User: $user->first_name . $user->lastname. Successfully!", data: $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        
        return $this->apiResponse(message: "Delete user: $user->email");
    }

    private function apiResponse($message = null, $data = null, $status = 200)
    {
        $body = [];
        !is_null($message) && $body['message'] = $message;
        !is_null($data) && $body['data'] = $data;
        return response()->json($body, $status);
    }
}
