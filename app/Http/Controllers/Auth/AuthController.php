<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'username' => 'required|unique:users,username',
                'email' => 'required|unique:users,email',
                'password' => 'required',
                'no_ktp' => 'required|unique:users,no_ktp',
                'date_of_birth' => 'required',
                'phone' => 'required',
                'description' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json($validate->errors());
            }
            $users = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'no_ktp' => $request->no_ktp,
                'date_of_birth' => $request->date_of_birth,
                'phone' => $request->phone,
                'description' => $request->description,
            ]);
            return response()->json([
                'msg' => 'Create Register Success',
                'data' => $users,
                'token' => $users->createToken('Api Token')->plainTextToken,
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'msg' => $th->getMessage()
            ]);
        }
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'msg' => 'Unauthorization'
            ]);
        }
        $users = User::where('username', $request->username)->firstOrFail();
        return response()->json([
            'msg' => 'Login Success',
            'user' => $users,
            'token' => $users->createToken('Api Token')->plainTextToken
        ]);
    }
    public function logout(Request $request)
    {
        try {
            $users = $request->user();
            $users->tokens->each(function ($token, $key) {
                $token->delete();
            });
            return response()->json([
                'msg' => 'Logout Success',
                'data' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Terjadi Kesalahan',
            ], 500);
        }
    }

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }
}
