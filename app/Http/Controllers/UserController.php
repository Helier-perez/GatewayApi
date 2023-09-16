<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

     /**
     * Return users list
     * @return Response
     */

     public function index()

     {
        $users = User::all();

        return $this->validResponse($users);
     }
 
     /**
      * Create an instance of user
      * @return Iluminate\Http\Response
      */
 
     public function store(Request $request)
 
     {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ];

        $this->validate($request, $rules);

        $fields = $request->all();
        $fields['password'] = Hash::make($request->password);

        $user = User::create($fields);

        return $this->validResponse($user, Response::HTTP_CREATED);
     }
 
     /**
      * Return a specific user
      * @return Response
      */
 
     public function show($user)
 
     {
        $user = User::findOrFail($user);

        return $this->validResponse($user);
     }
 
     /**
      * Update the information of an existing user
      * @return Iluminate\Http\Response
      */
 
     public function update(Request $request, $user)
 
     {
        
        $rules = [
            'title' => 'max:255',
            'email' => 'email|unique:users,email,' . $user,
            'pasword' => 'min:8|confirmed',
        ];

        $this->validate($request, $rules);

        $user = User::findOrFail($user);

        $user->fill($request->all());

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($user->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();
 
        return $this->validResponse($user);
    }
 
    /**
    * Removes an existing user
    * @return Iluminate\Http\Response
    */
 
    public function destroy($user)
    {
        $user = User::findOrFail($user);

        $user->delete();

        return $this->validResponse($user);
    }

    /**
    * Identifies the curren user
    * @return Iluminate\Http\Response
    */
 
    public function me(Request $request)
    {
        return $this->validResponse($request->user());
    }
 
 }
