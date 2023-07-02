<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // public function showAllUsers()
    // {
    //     return view('users.index');
    // }

    public function showAllUsers(){
        $users = $this->getAllUsers()->original['users'];
        return view('users.index', compact('users'));
    }

    public function showEditUser(User $user){
        // $user->load('roles');
        // $roles = $this->getAllRoles()->original['roles'];
        // return view('users.edit-user', compact('user', 'roles'));
        return view('users.edit-user', compact('user'));

    }

    public function showCreateUser(){
        // $roles = $this->getAllRoles()->original['roles'];
        // return view('users.create-user', compact('roles'));
        return view('users.create-user');
    }

    public function getAllUsers()
    {
        $users = User::get();
        return response()->json(['users' => $users],200);
    }

    public function getAllOrdersByUser(User $user)
    {
        $CustomerOrders = $user->load('CustomerOrders.Product.Category')->CustomerOrders;
        return response()->json(['customer_orders' => $CustomerOrders],200);
    }

    public function getAnUser(User $user)
    {
        return response()->json(['user' => $user],200); //forma usualmente ellos usan
    }

    public function getAllUsersWithOrders()
    {
        $users = User::with('CustomerOrders.Product')->get();
        return response()->json(['users' => $users],200);
    }
    /*
    public function createUser(Request $request)
    {
        $user = new User($request->all());
        $user->save();
        return response()->json(['user' => $user], 201);
    }
    sin request
    */

    public function createUser(CreateUserRequest $request)
    {
        $user = new User($request->all());
        $user->save();
        if($request->ajax()) return response()->json(['user'=>$user], 201);
        return back()->with('success','Usuario Creado');
    }
    /*
    public function updateUser(User $user, Request $request)
    {
        $user->update($request->all());
        return response()->json(['user' => $user->refresh()], 201);
    }
    sin el request
    */

    public function updateUser(User $user, UpdateUserRequest $request)
    {
        $user->update($request->all());
        return response()->json(['user' => $user->refresh()], 201);
    }


    // public function deleteUser(User $user, Request $request)
    // {
    //     $user->delete();
    //     return response()->json([], 204);
    // }


    public function deleteAUser(User $user, Request $request)
    {
        /*
        sin la vista
        $user->delete();
        return response()->json([], 204);
        */
        $user->delete();
        if($request->ajax()) return response()->json([], 204);
        return back()->with('success','Usuario eliminado');
    }
}
