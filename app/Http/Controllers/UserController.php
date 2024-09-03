<?php

namespace App\Http\Controllers;

use App\Events\NewEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UserController extends Controller
{
    private $secretKey = '4f8b6E!jP7^m@qZ$y1W&K*2xT9#Lr0D+3V^o5U8%Q&7C@N$F6*3R1#M2+9j!y^X$4D&K*o7T1L^6+Q@%2*3R9#W&y+F8^0m$5o+N1L#@6T*2^7Xy%9+Q3D';
    public function index()
    {
        $users = User::all();
        $code = 200;
        if (!$users->isEmpty()) {
            $message = 'Users List';
            $data = $users;
        } else {
            $message = 'Users Not Found';
        }
        return response()->json(['message' => $message, 'data' => $data], $code);
    }

    public function create(Request $request)
    {
        $customValidationMessages = [
            'name' => [
                'required' => 'Name is required.',
                'min' => 'The name field must be at least 3 characters.'
            ],
            'email' => [
                'required' => 'Email is required',
                'email' => 'Provide a valid email',
                'unique' => 'Email already exist'
            ],
            'password' => [
                'required' => 'Password is required',
                'min' => 'The Password field must be at least 3 characters.',
                'confirmed' => 'Password do not match'
            ]
        ];
        $validData = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3|confirmed',

        ], $customValidationMessages);
        if ($validData->fails()) {
            return response($validData->errors()->all(), 403);
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'isValidEmail' => User::ISVALIDEMAIL,
            'remember_token' => $this->createToken($request),
            'password' => bcrypt($request->password),
        ];

        if ($user = User::create($userData)) {
            NewEmail::dispatch($user);
            $code = 200;
            $message = 'User created successfully. We have sent a verification link to your email';
        } else {
            $code = 500;
            $message = 'Failed to create new user';
        }
        return response()->json(['user' => $user, 'message' => $message], $code);
    }
    public function createToken($request)
    {
        $data = Str::random(10);
        return $data;
    }
    public function validateemail($token)
    {
        if (User::where('remember_token', $token)->where('isValidEmail', '!=', 1)->update(
            [
                'isValidEmail' => 1,
                'email_verified_at' => now()
            ]
        )) {
            return redirect('/login');
        } else {
            return redirect()->back()->with('message', 'Invalid Access Token');
        }
    }
    public function login(Request $request)
    {
        $customValidationMessages = [
            'password' => [
                'required' => 'Password is required.',
                'min' => ' Password field must be at least 3 characters.'
            ],
            'email' => [
                'required' => 'Email is required',
                'email' => 'Provide a valid email',

            ],
        ];
        $validData = Validator::make($request->all(), [
            'password' => 'required|min:3',
            'email' => 'required|email',
        ], $customValidationMessages);
        if ($validData->fails()) {
            return response($validData->errors()->all(), 403);
        }

        $user = User::where('email', $request->email)->first();
        if (!empty($user)) {

            if (intval($user->isValidEmail) != 1) {

                NewEmail::dispatch($user);
                $code = 422;
                $message = 'Please validate your email. We have sent a varificaton link via email';
                return response()->json(['message' => $message, 'isLogin' => false], $code);
            }
            if (!Hash::check($request->password, $user->password)) {
                $code = 422;
                $message = 'Invalid credentials';
                return response()->json(['message' => $message, 'isLogin' => false], $code);
            } else {
                $code = 200;
                $message =  'You are login';
                $token = $user->createToken($this->secretKey, ['create', 'update'])->plainTextToken;
                return response()->json(
                    ['user' => $user, 'message' => $message, 'isLogin' => true, 'token' => $token],
                    $code,
                );
            }
        } else {
            $code = 422;
            $message = 'Invalid credentials';
            return response()->json(['message' => $message, 'isLogin' => false], $code);
        }
    }
}
