<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Flash;
use App\Models\User;
use App\Models\Role;
use App\Models\Tenant;

class UserController extends Controller
{
    public function index(){
        return view('dashboard');
    }

    public function create()
    {
        return view('center.create_user');
    }

    public function store(Request $request)
    {
        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
            ]);
        \Session::flash('flash_message','User Created Successfully!');
        return redirect(route('dashboard'));
    }

    public function home()
    {
        $users = User::all();
        foreach($users as $user)
        {
            $role = Role::where('id',$user->role_id)->first();
            $user->role_id = $role->type;
        }
        return view('home')->with('users',$users);
    }
}
