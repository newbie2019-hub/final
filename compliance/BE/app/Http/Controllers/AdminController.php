<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owner', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->guard('owner')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function update(Request $request) {
        try {
            $data = [
                'first_name' => $request->fname,
                'middle_name' => $request->mname,
                'last_name' => $request->lname,
                'email' => $request->email,
            ];

            if($request->password) {
                $data['password'] = Hash::make($request->password);
            }

            $book = Admin::find($request->id);

            $book->update($data);

           return response()->json(['message' => 'User updated successfully!'], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {

        auth()->logout();
        return response()->json(['message' => 'User logged out successfully!']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
