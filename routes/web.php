<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\CellierController;
use App\Http\Controllers\SAQController;
use App\Http\Controllers\BouteilleController;
use App\Http\Controllers\NoteBouteilleController;
use App\Http\Controllers\HomeController;


// Route d'accueil
Route::get('/', function () {
    return view('welcomee');
})->name('home');

// Routes nécessitant une authentification
Route::middleware(['auth'])->group(function () {
    // Pour se déconnecter
    Route::get('/logout', [CustomAuthController::class, 'logout'])->name('logout');

    // Pour ajouter un cellier
    Route::get('/AjouterCellier', [CellierController::class, 'create'])->name('cellier.create');
    Route::post('/AjouterCellier', [CellierController::class, 'store'])->name('cellier.store');
    Route::get('/ModifierCellier/{id}', [CellierController::class, 'edit'])->name('cellier.edit');
    Route::put('/ModifierCellier/{id}', [CellierController::class, 'update'])->name('cellier.update');
    Route::delete('/AjouterCellier/{id}', [CellierController::class, 'destroy'])->name('cellier.destroy');

    // Pour ajouter une bouteille dans un cellier
    Route::get('/Ajouter-bouteilles/{cellier_id}', [BouteilleController::class, 'index'])->name('Ajouter-bouteilles');
    Route::get('/Ajouter-bouteille-manuellement/{cellier_id}', [BouteilleController::class, 'AjouterbouteilleManuellement'])->name('Ajouter-bouteille-manuellement');
    Route::post('/addBouteilleManuellementPost', [BouteilleController::class, 'addBouteilleManuellementPost'])->name('addBouteilleManuellementPost');
    Route::post('/bouteilles/addBouteille/{id}', [BouteilleController::class, 'addBouteille'])->name('bouteilles.addBouteille');
    Route::delete('/bouteilles/{id}', [BouteilleController::class, 'destroy'])->name('bouteilles.destroy');

    // Pour voir les bouteilles d'un cellier
    Route::get('/mon-cellier', [CellierController::class, 'index'])->name('mon-cellier');

    // Pour modifier la quantité d'une bouteille dans un cellier
    Route::get('/modifierQte/{bouteille_id}', [BouteilleController::class, 'modifierBouteille'])->name('modifier-Qte');
    Route::post('/modifierQte/{bouteille_id}', [BouteilleController::class, 'modifierQteBouteille'])->name('modifier-Qte');

    // Recherche de bouteilles
    Route::get('/bouteilles/search', [BouteilleController::class, 'search'])->name('bouteilles.search');
    Route::get('/bouteilles/addBouteilleSearch/{id}', [BouteilleController::class, 'addBouteilleSearch'])->name('bouteilles.addBouteilleSearch');

    // Notes de bouteilles
    Route::get('/notes/listeNote', [NoteBouteilleController::class, 'listeNote'])->name('notes.listeNote');
    Route::post('/bouteilles/ajouterNote', [NoteBouteilleController::class, 'ajouterNote'])->name('bouteilles.ajouterNote');
    Route::delete('/bouteilles/supprimerNote', [NoteBouteilleController::class, 'destroyNote'])->name('note.destroyNote');

    // Recherche de bouteilles pour le footer
    Route::get('/bouteilles/rechercheFooterBouteille', [BouteilleController::class, 'rechercheFooterBouteille'])->name('bouteilles.rechercheFooterBouteille');
    Route::post('/bouteilles/rechercheFooterBouteillePost', [BouteilleController::class, 'indexRecherche'])->name('bouteilles.rechercheFooterBouteillePost');

    // Redirection vers HomeController après authentification
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

// Routes d'authentification
Route::get('/login', [CustomAuthController::class, 'index'])->name('login');
Route::post('/login', [CustomAuthController::class, 'authentication'])->name('login.authentication');
Route::get('/register', [CustomAuthController::class, 'create'])->name('register');
Route::post('/register', [CustomAuthController::class, 'store'])->name('register.store');

// Import de bouteilles SAQ
Route::get('/import', 'App\Http\Controllers\SAQController@import');

// Vous pouvez ajouter d'autres routes ici si nécessaire

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/add-bottle', [BouteilleController::class, 'méthode_associée'])->name('add.bottle');
Route::get('/purchase-list', [NomDuController::class, 'méthode_associée'])->name('purchase.list');
Route::post('/logout', [CustomAuthController::class, 'logout'])->name('logout');




