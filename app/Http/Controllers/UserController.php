<?php

namespace App\Http\Controllers;

use App\Utils\HTTPUtils;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function info(Request $request)
    {
        return HTTPUtils::returnJsonResponse($request->user());
    }
}
