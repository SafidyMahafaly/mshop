<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class UserControlleur extends Controller
{
    public function index(){
        return view('utilisateurs.index');
    }

    public function getUtilisateur(Request $request){
        $user  = User::with('roles')->get();
        return response()->json($user);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->addRole($request->role);
        event(new Registered($user));
        return back();
    }
}
