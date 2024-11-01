<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

    class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email',
                'password' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($validator, $code);
            }

            $credentials = $request->only('email', 'password');
            $token = Auth::guard("api")->attempt($credentials);

            if (!$token) {
                return response()->json(['msg' => 'error']);
            }

            $user = Auth::guard("api")->user();
            $user->token = $token;
            return response()->json(['msg' => $user]);


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function register(Request $request){
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($validator, $code);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if($user){
            return $this->login($request); //this returns the user token in the response
        }

        return response()->json(['msg' => 'something wrong !!']);
    }

    public function logout(Request $request){
        try{
            JWTAuth::invalidate($request->token);
            return response()->json(['msg' => 'success']);
        }catch (JWTException $E){
            return response()->json(['msg' => $E->getMessage()]);
        }
    }

    public function refresh(Request $request){
        $new_token = JWTAuth::refresh($request->token);
        if($new_token){
            return response()->json(['msg' => $new_token]);
        }
        return response()->json(['msg' => "error"]);
    }
}
