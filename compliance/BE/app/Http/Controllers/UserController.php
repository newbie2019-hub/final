<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->fname,
            'middle_name' => $request->mname,
            'last_name' => $request->lname,
        ];
        
        User::create($data);

        return response()->json(['success' => 'Account created successfuly!'], 200);
    }
}
