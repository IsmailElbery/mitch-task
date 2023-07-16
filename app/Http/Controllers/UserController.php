<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adminDashboard()
    {
        //get all users
        $users = User::all();
        return view('admin.dashboard', compact('users'));

    }

    public function userDashboard()
    {
        $user = auth()->user();
        return view('user.dashboard', compact('user'));
    }

    public function adminAdd()
    {
        return view('admin.add');
    }

    public function adminStore(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->role = $request->role;
        $user->save();

        if ($user) {
            return redirect()->route('admin.dashboard')->with('success', 'User added successfully');
        }
        else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function adminEdit($id)
    {
        $user = User::find($id);
        return view('admin.edit', compact('user'));
    }

    public function adminUpdate(Request $request)
    {
        $user = User::find($request->id);
        if($request->name){
            $user->name = $request->name;
        }
        if($request->email){
            $user->email = $request->email;
        }
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->role = $request->role;
        $user->save();

        if ($user) {
            return redirect()->route('admin.dashboard')->with('success', 'User updated successfully');
        }
        else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function adminDelete($id)
    {
        $user = User::find($id);
        $user->delete();

        if ($user) {
            return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully');
        }
        else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function userUpdate(Request $request)
    {
        $user = User::find($request->id);
        if($request->name){
            $user->name = $request->name;
        }
        if($request->email){
            $user->email = $request->email;
        }
        $user->role = $request->role;
        $user->save();

        if ($user) {
            return redirect()->route('user.dashboard')->with('success', 'User updated successfully');
        }
        else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
