<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Signup user
     * @unauthenticated
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:users|min:3|max:255',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = Str::slug($request->name).'@mail.com';
        $user->type = 'user';
        $user->password = Hash::make('claude');;
        $user->save();

        $personal_access_token = $user->createToken('hotshi_test_api');
        $data = $user;
        $data->token = $personal_access_token->plainTextToken;

        return new AuthResource($data);
    }

    /**
     * Login user
     * @unauthenticated
     */
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $user = User::where('name', $request->name)->firstOrFail();
        $personal_access_token = $user->createToken('hotshi_test_api');
        $data = $user;
        $data->token = $personal_access_token->plainTextToken;

        return new AuthResource($data);
    }
}
