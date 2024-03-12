<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class AuthenticationController extends Controller
{
    /**
    * Handle an incoming authentication request.
    */
    public function store()
    {
        //return response()->json([date("Y-m-d H:i:s")]);
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            // successfull authentication
            $user = User::find(Auth::user()->id);

            $user_token['token'] = $user->createToken('appToken')->accessToken;

            return response()->json([
                'success' => true,
                'token' => $user_token,
                'user' => $user,
            ], 200);
        } else {
            // failure to authenticate
            return response()->json([
                'success' => false,
                'message' => 'Failed to authenticate.',
            ], 401);
        }
    }

    /**
   * Destroy an authenticated session.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
    public function destroy(Request $request)
    {
        if (Auth::user()) {
            $request->user()->token()->revoke();

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully',
            ], 200);
        }
    }

    /**
 * API Registerx
 *
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 */
public function register(Request $request)
{
    $rules = [
        'name' => 'unique:users|required',
        'email'    => 'unique:users|required',
        'password' => 'required',
    ];


    $input     = $request->only('name', 'email','password');
    $validator = Validator::make($input, $rules);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'error' => $validator->messages()]);
    }
    $name = $request->name;
    $email    = $request->email;
    $password = $request->password;
    $created_at = date("Y-m-d H:i:s");
    $role_id = 2;
    $user     = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password), 'role_id' =>  $role_id, 'created_at' => $created_at, 'updated_at' => $created_at]);
    return response()->json([
        'success' => true,
        'message' => $user,
    ], 200);

}
}
