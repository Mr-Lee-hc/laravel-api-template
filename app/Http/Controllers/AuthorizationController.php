<?php

namespace App\Http\Controllers;

use App\Models\Authorization;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    public function login(Request $request)
    {
        $name = $request->name;
        $password = $request->password;
        if(!$user = User::login($name,$password)){
            return $this->errorUnauthorizedResponse('用户名或密码错误');
        }

        $token = auth()->login($user);
        $authorization = new Authorization($token);

        $user->meta = $authorization->toArray();

        return $user;
    }

    public function logout()
    {
        auth()->logout();
        return response('',204);
    }
}
