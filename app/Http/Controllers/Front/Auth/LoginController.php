<?php

namespace App\Http\Controllers\Front\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    //

    public function Login (Request $request){
        dd($request->email, $request->pass);
    }
}
