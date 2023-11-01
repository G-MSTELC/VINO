<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\CellierController;
use App\Http\Controllers\SAQController;
use App\Http\Controllers\BouteilleController;
use App\Http\Controllers\NoteBouteilleController;
use App\Http\Controllers\HomeController;

// Routes d'authentification
Route::get('/login', [CustomAuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [CustomAuthController::class, 'authentication'])->name('login.authentication')->middleware('guest');
Route::get('/register', [CustomAuthController::class, 'create'])->name('register');
Route::post('/register', [CustomAuthController::class, 'store'])->name('register.store');
Route::post('/logout', [CustomAuthController::class, 'logout'])->name('logout'); // La route de déconnexion est correcte ici

// Routes nécessitant une authentification
Route::middleware(['auth'])->group(function () {
    // Pour ajouter un cellier
    Route::get('/ajouter-cellier', [CellierController::class, 'create'])->name('cellier.create');
    Route::post('/ajouter-cellier', [CellierController::class, 'store'])->name('cellier.store');
    Route::get('/modifier-cellier/{id}', [CellierController::class, 'edit'])->name('cellier.edit');
    Route::put('/modifier-cellier/{id}', [CellierController::class, 'update'])->name('cellier.update');
    Route::delete('/supprimer-cellier/{id}', [CellierController::class, 'destroy'])->name('cellier.destroy');

    // Pour ajouter une bouteille dans un cellier
    Route::get('/ajouter-bouteilles/{cellier_id}', [BouteilleController::class, 'index'])->name('ajouter-bouteilles');
    Route::get('/ajouter-bouteille-manuellement/{cellier_id}', [BouteilleController::class, 'ajouterBouteilleManuellement'])->name('ajouter-bouteille-manuellement');
    Route::post('/ajouter-bouteille-manuellement', [BouteilleController::class, 'addBouteilleManuellementPost'])->name('ajouter-bouteille-manuellement-post');
    Route::post('/ajouter-bouteille/{id}', [BouteilleController::class, 'addBouteille'])->name('bouteilles.addBouteille');
    Route::delete('/supprimer-bouteille/{id}', [BouteilleController::class, 'destroy'])->name('bouteilles.destroy');

    // Pour voir les bouteilles d'un cellier
    Route::get('/mon-cellier', [CellierController::class, 'index'])->name('mon-cellier');

    // Pour modifier la quantité d'une bouteille dans un cellier
    Route::get('/modifier-quantite/{bouteille_id}', [BouteilleController::class, 'modifierBouteille'])->name('modifier-quantite');
    Route::post('/modifier-quantite/{bouteille_id}', [BouteilleController::class, 'modifierQuantiteBouteille'])->name('modifier-quantite');

    // Recherche de bouteilles
    Route::get('/recherche-bouteilles', [BouteilleController::class, 'search'])->name('recherche-bouteilles');
    Route::get('/ajouter-bouteille-search/{id}', [BouteilleController::class, 'addBouteilleSearch'])->name('ajouter-bouteille-search');

    // Notes de bouteilles
    Route::get('/liste-notes', [NoteBouteilleController::class, 'listeNote'])->name('liste-notes');
    Route::post('/ajouter-note', [NoteBouteilleController::class, 'ajouterNote'])->name('ajouter-note');
    Route::delete('/supprimer-note', [NoteBouteilleController::class, 'destroyNote'])->name('supprimer-note');
    
    // Redirection vers HomeController après authentification
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

// Import de bouteilles SAQ
Route::get('/import', [SAQController::class, 'import']);

// Vous pouvez ajouter d'autres routes ici si nécessaire

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/add-bottle', [BouteilleController::class, 'methode_associée'])->name('add.bottle');
Route::get('/purchase-list', [NomDuController::class, 'methode_associée'])->name('purchase.list');

Route::get('/search', [ControllerName::class, 'methodName'])->name('search');
Route::get('/add-cellar', [ControllerName::class, 'methodName'])->name('add.cellar');
