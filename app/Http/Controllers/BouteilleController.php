<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bouteille; // Assurez-vous d'importer le modèle Bouteille

class BouteilleController extends Controller
{
    public function index($cellier_id)
    {
        // Logique pour afficher la liste des bouteilles dans le cellier
        $bouteilles = Bouteille::where('cellier_id', $cellier_id)->get();
        return view('bouteilles.index', compact('bouteilles'));
    }

    public function indexRecherche(Request $request)
    {
        // Logique pour afficher la liste des bouteilles avec des filtres de recherche
        $query = $request->input('search_query');
        $bouteilles = Bouteille::where('nom', 'like', "%$query%")->get();
        return view('bouteilles.index', compact('bouteilles'));
    }

    public function modifierBouteille(Request $request, $id)
    {
        // Logique pour afficher la vue de modification de quantité de bouteille
        $bouteille = Bouteille::findOrFail($id);
        return view('bouteilles.modifier', compact('bouteille'));
    }

    public function modifierQteBouteille(Request $request, $bouteille_id)
    {
        // Logique pour mettre à jour la quantité d'une bouteille dans le cellier
        $bouteille = Bouteille::findOrFail($bouteille_id);
        $bouteille->quantite = $request->input('quantite');
        $bouteille->save();
        return redirect()->route('bouteilles.index', ['cellier_id' => $bouteille->cellier_id])->with('success', 'Quantité mise à jour.');
    }

    public function addBouteille(Request $request, $id)
    {
        // Logique pour ajouter une bouteille au cellier
        $bouteille = new Bouteille();
        $bouteille->cellier_id = $id;
        $bouteille->nom = $request->input('nom');
        // Autres attributs de la bouteille...
        $bouteille->save();
        return redirect()->route('bouteilles.index', ['cellier_id' => $id])->with('success', 'Bouteille ajoutée.');
    }

    public function AjouterbouteilleManuellement(Request $request, $cellier_id)
    {
        // Logique pour afficher le formulaire d'ajout manuel de bouteille
        return view('bouteilles.ajouter_manuellement', compact('cellier_id'));
    }

    public function addBouteilleManuellementPost(Request $request)
    {
        // Logique pour ajouter une bouteille manuellement au cellier
        $bouteille = new Bouteille();
        $bouteille->cellier_id = $request->input('cellier_id');
        $bouteille->nom = $request->input('nom');
        // Autres attributs de la bouteille...
        $bouteille->save();
        return redirect()->route('bouteilles.index', ['cellier_id' => $request->input('cellier_id')])->with('success', 'Bouteille ajoutée manuellement.');
    }

    public function destroy(Request $request, $id)
    {
        // Logique pour supprimer une bouteille du cellier
        $bouteille = Bouteille::findOrFail($id);
        $cellier_id = $bouteille->cellier_id;
        $bouteille->delete();
        return redirect()->route('bouteilles.index', ['cellier_id' => $cellier_id])->with('success', 'Bouteille supprimée.');
    }

    public function search(Request $request)
    {
        // Logique pour effectuer une recherche de bouteilles
        $query = $request->input('query');
        $bouteilles = Bouteille::where('nom', 'like', "%$query%")->get();
        return response()->json($bouteilles);
    }

    public function addBouteilleSearch($id, Request $request)
    {
        // Logique pour ajouter une bouteille depuis une recherche spécifique
        $bouteille = Bouteille::findOrFail($id);
        return view('bouteilles.ajouter', compact('bouteille', 'cellier_id'));
    }

    public function filter(Request $request, $cellier_id)
    {
        // Logique pour filtrer les bouteilles en fonction des critères
        $price = $request->input('price');
        $country = $request->input('country');
        $millesime = $request->input('millesime');
        $type = $request->input('type');
        
        $bouteilles = Bouteille::where('cellier_id', $cellier_id);
        
        if (!empty($price)) {
            $bouteilles->orderBy('prix', $price);
        }

        if (!empty($country)) {
            $bouteilles->where('pays', $country);
        }

        if (!empty($millesime)) {
            $bouteilles->where('millesime', $millesime);
        }

        if (!empty($type)) {
            $bouteilles->where('type', $type);
        }

        $bouteilles = $bouteilles->get();
        return view('bouteilles.index', compact('bouteilles'));
    }

    public function rechercheFooterBouteille()
    {
        // Logique pour afficher une vue de recherche de bouteilles
        return view('bouteilles.recherche_footer');
    }
}
