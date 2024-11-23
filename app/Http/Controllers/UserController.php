<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Exception;

class UserController extends Controller
{
    /**
     * Function: Register
     * Description: This function is used to Register user API
     * @return void
     * @param NA
    */
    public function register(Request $request) {
        try{
            $result = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);
            return response()->json([
                'data' => $result,
                'status' => 'success',
                'message' => 'User created successfully'
            ],201);
        }catch(Exception $e){
            return response()->json([
                'data' => $e->getMessage(),
                'status' => 'error',
                'message' => 'Something went wrong'
            ],500);
        }
    }
}
