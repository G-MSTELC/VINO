<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function create()
    {
        return view('auth.registration');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|min:2|max:20|alpha',
            'prenom' => 'required|min:2|max:20|alpha',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ],
        [
            'nom.required' => 'Veuillez saisir votre nom',
            'nom.min' => 'Votre nom doit contenir au moins 2 caractères',
            'nom.max' => 'Votre nom ne doit pas dépasser 20 caractères',
            'nom.alpha' => 'Votre nom ne doit contenir que des lettres',
            'prenom.required' => 'Veuillez saisir votre prénom',
            'prenom.min' => 'Votre prénom doit contenir au moins 2 caractères',
            'prenom.max' => 'Votre prénom ne doit pas dépasser 20 caractères',
            'prenom.alpha' => 'Votre prénom ne doit contenir que des lettres',
            'email.required' => 'Veuillez saisir votre adresse email',
            'password.required' => 'Veuillez saisir votre mot de passe',
            'password.min' => 'Votre mot de passe doit contenir au moins 6 caractères',
        ]);

        $user = new User;
        $user->nom = $request->input('nom');
        $user->prenom = $request->input('prenom');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
       
        return redirect(route('login'))->withSuccess('Utilisateur enregistré');
    }

    public function authentication(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ], [
            'email.required' => 'Veuillez saisir votre adresse email',
            'password.required' => 'Veuillez saisir votre mot de passe',
        ]);
    
        $credentials = $request->only('email', 'password');

        if (!Auth::validate($credentials)) {
            return redirect('login')
                ->withErrors([
                    'email' => 'L\'adresse email ou le mot de passe est incorrect'
                ])
                ->withInput();
        }
    
        $user = Auth::getProvider()->retrieveByCredentials($credentials);
    
        Auth::login($user, $request->get('remember'));

        return redirect()->route('home')->with('success', 'Vous êtes connecté')->with('name', $user->nom);
    }

    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect(route('login'))->withSuccess('Vous êtes déconnecté');
    }
}
