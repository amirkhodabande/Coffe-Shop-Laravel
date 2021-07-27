<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register api
     *
     * @param \App\Http\Requests\RegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request): \Illuminate\Http\Response
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $user->token = $user->createToken('MyApp')->plainTextToken;

        return response(['message' => 'User registered successfully.', 'user' => $user]);
    }
    /**
     * Login api
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): \Illuminate\Http\Response
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $user->token = $user->createToken('MyApp')->plainTextToken;

            return response(['message' => 'User logged in successfully.', 'user' => $user]);
        }
        else{
            return response("Unauthorized");
        }
    }
}
