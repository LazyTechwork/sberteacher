<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\HTTPUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthorizationController extends Controller
{
    /**
     * Authorization for users in API
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function auth(Request $request)
    {
//        Validating params
        $validator = validator($request->all(), [
            "email"    => ['required', 'string', 'max:255', 'email'],
            "password" => ['required', 'string', 'max:255'],
            "agent"    => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return HTTPUtils::returnJsonErrorBag($validator->errors(), 422);
        }
//        Getting all variables
        $email = $request->get('email');
        $password = $request->get('password');
        $agent = $request->get('agent');

//        Getting user with email
        $user = User::where('email', $email)->first();

//        Checking password
        if (!$user || !Hash::check($password, $user->password))
            return HTTPUtils::returnJsonErrorResponse(HTTPUtils::$LOGIN_FAIL);

//        Creating token and returning response
        $token = $user->createToken($agent)->plainTextToken;
        return HTTPUtils::returnJsonResponse(["token" => $token, "user" => $user]);
    }
}
