<?php

namespace App\Http\Controllers;

use App\Models\Cellier;
use App\Models\BouteilleCellier; // Import de la classe BouteilleCellier
use App\Models\Note;
use Illuminate\Http\Request;

class CellierController extends Controller
{
    public function index($id)
    {
        $cellier = Cellier::findOrFail($id);
        $nomCellier = $cellier->nom_cellier;
        $bouteilleCelliers = BouteilleCellier::where("cellier_id", $id)->get();

        return view("cellier.monCellier", compact("bouteilleCelliers", "cellier", "nomCellier"));
    }

    public function create()
    {
        return view("cellier.addCellier");
    }

    public function store(Request $request)
    {
        $request->validate([
            "nom_cellier" => "required|max:10|min:1|unique:celliers,nom_cellier,NULL,id,user_id," . auth()->user()->id,
        ]);

        $cellier = new Cellier();
        $cellier->nom_cellier = $request->input("nom_cellier");
        $cellier->user_id = auth()->user()->id;
        $cellier->save();

        return redirect()->route("home")->withSuccess("Cellier enregistré.");
    }

    public function edit($id)
    {
        $cellier = Cellier::findOrFail($id);
        return view("cellier.modifyCellier", compact("cellier"));
    }

    public function update(Request $request, $id)
    {
        $cellier = Cellier::findOrFail($id);
        $request->validate([
            "nom_cellier" => "required|max:10|min:1|unique:celliers,nom_cellier," . $cellier->id . ",id,user_id," . auth()->user()->id,
        ]);

        $cellier->nom_cellier = $request->input("nom_cellier");
        $cellier->save();

        return redirect()->route("home")->withSuccess("Cellier modifié.");
    }

    public function destroy($id)
    {
        $bouteilleCelliers = BouteilleCellier::where("cellier_id", $id)->get();

        foreach ($bouteilleCelliers as $bouteilleCellier) {
            Note::where("bouteille_cellier_id", $bouteilleCellier->id)->delete();
        }

        BouteilleCellier::where("cellier_id", $id)->delete();
        Cellier::destroy($id);

        return redirect()->route("home")->withSuccess("Cellier supprimé.");
    }
}
