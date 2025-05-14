<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\log;
use Tymon\JWTAuth\Facades\JWTAuth;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function signup(Request $request)
    {
        log::info("gfdgdfa");
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return response()->json(['message' => 'User created. Verify email.'], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if (!$token = JWTAuth::attempt($data)) {
            return response()->json(['error' => 'Invalid credentials.'], 401);
        }

        // Generate a token or session for the user
        // For example, using Laravel Passport or Sanctum

        return response()->json(['message' => 'Login successful.','token'=>$token], 200);
    }
    
    public function logout(Request $request)
    {
                
            try {
                
                JWTAuth::invalidate(JWTAuth::parseToken());
        
                return response()->json(['message' => 'Successfully logged out.'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to log out, please try again.'], 500);
            }
        
    }
}
