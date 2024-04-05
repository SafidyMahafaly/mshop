<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class UserControlleur extends Controller
{
    public function index(){
        $users  = User::with('roles')->where('email','!=','kkk@gmail.com')->get();
        // dd($users);
        return view('utilisateurs.index',compact('users'));
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
    public function destroy($id){
        User::find($id)->delete();
        return back();
    }
    public function update(Request $request)
    {
        $user = User::find($request->id);

        // Mettez à jour les propriétés de l'utilisateur avec les données du formulaire
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Vérifiez si un nouveau mot de passe a été fourni
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Mettez à jour le rôle de l'utilisateur
        $user->syncRoles([$request->input('role')]);

        // Enregistrez les modifications dans la base de données
        $user->save();

        // Redirigez l'utilisateur ou affichez un message de succès
        return redirect()->back()->with('success', 'User updated successfully!');
    }
}
