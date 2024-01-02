<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserControlleur extends Controller
{
    public function index(){
        return view('utilisateurs.index');
    }

    public function getUtilisateur(Request $request){
        $user  = User::all();
        return response()->json($user);
    }
}
