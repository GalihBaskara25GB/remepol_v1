<?php 
namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{ 
    public function __construct() {
        $this->token_key = env('TOKEN_KEY');
    }

    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'role' => $fields['role'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken($this->token_key)->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();
        
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Invalid Email or Password'
            ], 401);
        }
        
        $user->tokens()->delete();
        $token = $user->createToken(env('TOKEN_KEY'))->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

    public function check() {
      $tokenStatus = auth('sanctum')->check();
      
      $response = array();
      $response['message'] = 'invalid token';
      $response['user'] = []; 
      $responseCode = 401;
      
      if($tokenStatus) {
        $responseCode = 200;
        $response['message'] = 'token is valid';
        $response['user'] = auth('sanctum')->user(); 
      }

      return response($response, $responseCode);
    }

    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        $token = $user->createToken($this->token_key)->plainTextToken;

        $response = [
            'token' => $token
        ];

        return response($response, 201);
    }
}