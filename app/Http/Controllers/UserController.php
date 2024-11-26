<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{
    /**
     * Function: Register
     * Description: This function is used to Register user API
     * @param NA
     * @return JsonResponse
     */
    public function register(Request $request) {
        try{
            $result = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ]);
            return response()->json([
                'message' => 'User created successfully',
                'data' => $result
            ],201);

        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status_code' => $e->getCode()
            ],500);
        }
    }
    /**
     * Function: Login
     * Description: This function is used to Login user API
     * @param
     * @return JsonResponse
     */
    public function login(Request $request) {
        try{
            $result = User::where('email','=',$request->input('email'))
            ->where('password','=',$request->input('password'))
            ->select('id')->first();
            if($result!==null){
                $token = JWTToken::CreateToken($request->input('email'),$result->id);
                return response()->json([
                    'message' => 'User Login successfully',
                    'token' => $token,
                    'status_code' => 200,
                    'success' => true
                ],201)->cookie('token',$token,time()+60*60*24);
            }else{
                return response()->json([
                    'success' => false,
                    'status_code' => '401',
                    'message' => 'Invalid email or password'
                ],401);
            }
        }catch(Exception $e){
            return response()->json([
                'data' => $e,
                'status' => 'error',
                'message' => 'Something went wrong'
            ],500);
        }
    }
    /**
     * Function: SendOtpCode
     * Description: This function is used to SendOtpCode user API
     * @param
     * @return JsonResponse
     */
    public function SendOtpCode(Request $request) {
        $email = $request->input('email');
        $otp = rand(100000,999999);
        $count = User::where('email','=',$email)->count();
        if($count==1){
            Mail::to($email)->send(new OTPMail($otp));

            User::where('email','=',$email)->update(['otp'=>$otp]);
            return response()->json([
                'message' => 'OTP sent successfully',
                'status_code' => 201,
                'success' => true
            ],201);
        }else{
            return response()->json([
                'message' => 'User Not Found',
                'status_code' => 404,
                'success' => false
            ],500);
        }
    }
    /**
     * Function: VerifyOTP
     * Description: This function is used to VerifyOTP user API
     * @param
     * @return JsonResponse
     */
    public function verifyOTP(Request $request) {
        try{
            $email = $request->input('email');
            $otp = $request->input('otp');
            $count = User::where('email','=',$email)->where('otp','=',$otp)->count();
            if($count==1){
                User::where('email','=',$email)->update(['otp'=>'0']);
                $token = JWTToken::CreateTokenForSetPassword($request->input('email'));
                return response()->json([
                    'message' => 'OTP Verify successfully',
                    'token' => $token,
                    'success' => true
                ],201)->cookie('token',$token,time()+60*60*24);
            }else{
                return response()->json([
                    'message' => 'User Not Found',
                    'status_code' => 404,
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false
            ],500);
        }
    }
    /**
     * Function: Reset Password
     * Description: This function is used to resetPassword user API
     * @param
     * @return JsonResponse
     */
    public function resetPassword(Request $request) {
        try{
            $email = $request->header('email');
            $password = $request->input('password');
            $updatePassword = User::where('email','=',$email)->update(['password'=>$password]);
            if($updatePassword){
                return response()->json([
                    'message' => 'Password reset successfully',
                    'status_code' => 201,
                ],201);
            }else{
                return response()->json([
                    'message' => 'User Not Found',
                    'status_code' => 404,
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status_code' => 500

            ],500);
        }
    }
    /**
     * Function: logOut
     * Description: This function is used to logOut user API
     * @param
     * @return JsonResponse
     */
    public function logOut()
    {
        return response()->json([
            'message' => 'Logged out successfully',
            'status_code' => 201,
        ],201)->cookie('token','',-1);
    }
}
