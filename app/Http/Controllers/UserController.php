<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    public function showAllUsers(){
        $users = $this->getAllUsers()->original['users'];
        return view('users.index2', compact('users'));
    }

    public function showEditUser(User $user){
        $user->load('roles');
        $roles = $this->getAllRoles()->original['roles'];
        return view('users.edit-user', compact('user', 'roles'));
    }

    public function showCreateUser(){
        $roles = $this->getAllRoles()->original['roles'];
        return view('users.create-user', compact('roles'));
    }

    public function getAllRoles(){
        $roles = Role::all()->pluck('name');
        return response()->json(['roles' => $roles], 200);
    }

    public function getAllUsers()
    {
        $users = User::get();
        return response()->json(['users' => $users],200);
    }

    public function getAllOrdersByUser(User $user)
    {
        $CustomerOrders = $user->load('CustomerOrders.Product.Category')->CustomerOrders;
        //dd(Auth::user()->id);
        return response()->json(['customer_orders' => $CustomerOrders],200);
    }

    public function getAllOrdersByUserAuth()
    {
        $userId =  Auth::user()->id;
        $customerOrders = User::findOrFail($userId)
            ->load('CustomerOrders.Product.Category')
            ->CustomerOrders;

        return response()->json(['customer_orders' => $customerOrders], 200);
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

    public function createUser(CreateUserRequest $request)
    {
        try{
            DB::beginTransaction();
            $user = new User($request->all());
            $user->save();
            $user->assignRole($request->role);
            DB::commit();

            if($request->ajax()) return response()->json(['user'=>$user], 201);
            return back()->with('success','Usuario Creado');
        }
        catch (\Throwable $th){
            DB::rollback();
            throw $th;
        }
    }

    public function updateUser(User $user, UpdateUserRequest $request)
    {

        try{
            DB::beginTransaction();
            $allRequest = $request->all();
            if(!isset($allRequest['password'])){
                if(!$allRequest['password']) {
                    unset($allRequest['password']);
                }
            }
            $user->update($allRequest);
            $user->syncRoles([$request->role]);
            DB::commit();

            if($request->ajax()) return response()->json(['user' => $user->refresh()], 201);
            return back()->with('success','Usuario editado');
        }
        catch (\Throwable $th){
            DB::rollback();
            throw $th;
        }
    }

    //para el boton delete
    public function deleteUser(User $user, Request $request)
    {
        $user->delete();
        if($request->ajax()) return response()->json([], 204);
        return back()->with('success','Usuario eliminado');
    }
}
