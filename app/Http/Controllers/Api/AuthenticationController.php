<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;




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
            if($user->id == 1){
                $user->assignRole('admin');
                $user->givePermissionTo('create users');
                $user->givePermissionTo('edit users');
                $user->givePermissionTo('delete users');
                $user->givePermissionTo('view users');
            }
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
        $selected_role = $request->role;
        $check_authentication = Auth::user();

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

        if($selected_role == 'admin' && $check_authentication && $check_authentication->hasRole('admin')){
            $user = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password), 'role_id' =>  $role_id, 'created_at' => $created_at, 'updated_at' => $created_at]);
            // To assing role to customer
            $user->assignRole($selected_role);
            return response()->json([
                'success' => true,
                'message' => $user,
            ], 200);
        }else if($selected_role != 'admin'){
            $user = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password), 'role_id' =>  $role_id, 'created_at' => $created_at, 'updated_at' => $created_at]);
            // To assing role to customer
            $user->assignRole('customer');
            return response()->json([
                'success' => true,
                'message' => $user,
            ], 200);
        }else{
            return response()->json([
                'message' => $check_authentication,
            ], 200);
        }
    }


    /**
     * API Registerx
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @description return all users if query string @param role (role name) is empty
     */
    public function get_all_users(Request $request){
        $selected_role = $request->role;
        $user = Auth::user();
        if ($user) {
            if($user->hasRole('admin')){
                if($selected_role == 'customer'){
                    $users = User::whereHas(
                        'roles', function($q){
                            $q->where('name', 'customer');
                        }
                    )->get();
                }else if($selected_role == 'subscriber'){
                    $users = User::whereHas(
                        'roles', function($q){
                            $q->where('name', 'subscriber');
                        }
                    )->get();
                }else if($selected_role == 'admin'){
                    $users = User::whereHas(
                        'roles', function($q){
                            $q->where('name', 'admin');
                        }
                    )->get();
                }else{
                    $users = User::all();
                }
                // Retrieve all users from the database
                return response()->json($users, 200); // Return the data as JSON
            }else{
                return response()->json([
                    'message' => $user,
                ], 200);
            }

        }else{
            return response()->json([
                'message' => $user,
            ], 200);
        }
    }


    /**
     * API Updatex
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @description update user by admin
     */

    public function update_user(Request $request, string $id)
    {
        $check_authentication = Auth::user();
        $user = User::find($id);


        if($user->name != $request->name){
            $rules['name'] = 'unique:users|required';
        }
        if($user->email != $request->email){
            $rules['email'] = 'unique:users|required';
        }

        if(isset($rules)){
            $input     = $request->only('name', 'email','password');
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->messages()]);
            }
        }

        $user->name = $request->name;
        $user->email    = $request->email;
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->updated_at = date("Y-m-d H:i:s");
        if($check_authentication && $check_authentication->hasRole('admin')){
            if($user->update()){
                return response()->json(['success' => true, 'message' => 'Record updated.', $user]);
            } else {
                return response()->json(['success' => false, 'No record updated!']);
            }
        }else{
            return response()->json([
                'message' => $check_authentication,
            ], 200);
        }
    }

    /**
     * API Deletex
     *
     * @param Request $request
     * @param string id
     * @return \Illuminate\Http\JsonResponse
     * @description delete user by admin
     */
    public function delete_user(Request $request, string $id){
        $check_authentication = Auth::user();
        if($check_authentication && $check_authentication->hasRole('admin')){
            $user = User::find($id);
            if($user){
                $user->delete();
                return response()->json(['success' => true, 'message' => 'Record deleted.']);
            }else{
                return response()->json(['success' => false, 'message' => 'No record fount!']);
            }

        }else{
            return response()->json([
                'message' => $check_authentication,
            ], 200);
        }

    }


}

