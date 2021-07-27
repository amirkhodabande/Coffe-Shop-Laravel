<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
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
//            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            return response("Unauthorized");
        }
    }
}
