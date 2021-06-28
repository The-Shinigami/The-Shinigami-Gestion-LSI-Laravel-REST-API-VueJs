<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Prof;
use App\Models\Admin;
use App\Models\Module;
use App\Models\Suivre;
use App\Models\Note;
use App\Models\Salle;
use App\Models\Seance;
use App\Models\Reservation;
use App\Models\Pfe;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class etudiantController extends Controller
{
    public function getNoteEtudiant(Request $request)
    {

        $etudiant = Suivre::where('etudiant_id', '=', $request->id)->get();
        $Notes = array();
        $Modules = array();
        $semestres = array();
        foreach ($etudiant as $etu) {
            array_push($Notes, $etu->note);
            array_push($Modules, $etu->note->module->module);
            array_push($Modules, $etu->note->module->semestre);
        }
        return response()->json(["notes" => $Notes]);
    }

    public function getNotificationEtudiant(Request $request)
    {
        $reservations = Reservation::where('decision', 'accepter')->get();
        $semestre_id = Etudiant::where('id', $request->id)->value('semestre_id');
        $notification = array();
        foreach ($reservations as $reservation) {
            if ($reservation->module->semestre_id == $semestre_id) {
                array_push($notification, (object) array(
                    "module" => $reservation->module, "seance" => $reservation->seance,
                    "salle" => $reservation->seance->salle, "decision" =>  $reservation->decision
                ));
            }
        }

        return response()->json([
            "notification" => $notification
        ]);
    }
    public function getEmploiEtudiant(Request $request)
    {
        /* $etudiant = Etudiant::where([['email', '=', $request->email],[ 'date de naissance', '=', $request->date]])->get(); */
        if ($request->role == "etudiant") {
            $etudiant = Etudiant::where('id', $request->id)->get();
            $emploit = new emploit();
            $emploit->setUtilisateur($etudiant[0]);

            $semestres = $emploit->getSemestre();
            return  response()->json([
                'nom' => $emploit->getNom(),
                'semestre' => $semestres,
                'ModuleLundiMatin' => $emploit->getModuleLundiMatin(),
                'ModuleLundiSoire' =>  $emploit->getModuleLundiSoire(),
                'ModuleMardiMatin' =>  $emploit->getModuleMardiMatin(),
                'ModuleMardiSoire' =>  $emploit->getModuleMardiSoire(),
                'ModuleMercrediMatin' => $emploit->getModuleMercrediMatin(),
                'ModuleMercrediSoire' => $emploit->getModuleMercrediSoire(),
                'ModuleJeudiMatin' => $emploit->getModuleJeudiMatin(),
                'ModuleJeudiSoire' => $emploit->getModuleJeudiSoire(),
                'ModuleVendrediMatin' => $emploit->getModuleVendrediMatin(),
                'ModuleVendrediSoire' => $emploit->getModuleVendrediSoire(),
                'ModuleSamediMatin' => $emploit->getModuleSamediMatin(),
                'ModuleSamediSoire' => $emploit->getModuleSamediSoire(),
            ]);
        }

        return ["access" => "denied"];
    }
    public function getPfeEtudiant(Request $req)
    {
        $pfe = Pfe::where('etudiant_id', $req->id)->first();
        return  response()->json([
            "prof" => $pfe->prof->nom . " " . $pfe->prof->prenom,
            "etudiant" => $pfe->etudiant->nom . " " . $pfe->etudiant->prenom,
            "salle" => $pfe->salle->numero,
            "sujet" => $pfe->sujet,
            "date" => $pfe->date

        ]);
    }
}
class  emploit
{
    private $etudiant;

    public function setUtilisateur($etudiant)
    {
        $this->etudiant = $etudiant;
    }
    public function getNom()
    {
        return $this->etudiant->nom;
    }
    public function getSemestre()
    {

        return $this->etudiant->semestre->semestre;
    }
    public function getModuleLundiMatin()
    {
        $the_module = " ";
        $salle ="";
        foreach ($this->etudiant->semestre->module as $module) {

            if ($module->seance->jour == "lundi" && $module->seance->heure == "9:00h -> 12:45h") {

                $the_module =  $the_module . $module->module;
                $salle =  " Numero du salle : " . $module->seance->salle->numero;
            } 
        }
        return $the_module   . $salle ;
    }

    public function getModuleLundiSoire()
    {
        $the_module = " ";
        $salle = "";
        foreach ($this->etudiant->semestre->module as $module) {
            if ($module->seance->jour == "lundi" && $module->seance->heure == "15:00h -> 18:45h") {
                $the_module =  $the_module . $module->module;
                $salle =  $module->seance->salle->numero;
            }
        }
        return $the_module   . $salle;
    }

    public function getModuleMardiMatin()
    {
        $the_module = " ";
        $salle = "";
        foreach ($this->etudiant->semestre->module as $module) {
            if ($module->seance->jour == "mardi" && $module->seance->heure == "9:00h -> 12:45h") {
                $the_module =  $the_module . $module->module;
                $salle =  " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module  . $salle;
    }

    public function getModuleMardiSoire()
    {
        $the_module = " ";
        $salle = "";
        foreach ($this->etudiant->semestre->module as $module) {
            if ($module->seance->jour == "mardi" && $module->seance->heure == "15:00h -> 18:45h") {
                $the_module =  $the_module . $module->module;
                $salle =  " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module  .  $salle;
    }
    public function getModuleMercrediMatin()
    {
        $the_module = " ";
        $salle = "";
        foreach ($this->etudiant->semestre->module as $module) {
            if ($module->seance->jour == "mercredi" && $module->seance->heure == "9:00h -> 12:45h") {
                $the_module =  $the_module . $module->module;
                $salle =  " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module   . $salle;
    }

    public function getModuleMercrediSoire()
    {
        $the_module = " ";
        $salle = "";
        foreach ($this->etudiant->semestre->module as $module) {
            if ($module->seance->jour == "mercredi" && $module->seance->heure == "15:00h -> 18:45h") {
                $the_module =  $the_module . $module->module;
                $salle =  " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module  .  $salle;
    }
    public function getModuleJeudiMatin()
    {
        $the_module = " ";
        $salle = "";
        foreach ($this->etudiant->semestre->module as $module) {
            if ($module->seance->jour == "jeudi" && $module->seance->heure == "9:00h -> 12:45h") {
                $the_module =  $the_module . $module->module;
                $salle =  " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module   . $salle;
    }

    public function getModuleJeudiSoire()
    {
        $the_module = " ";
        $salle = "";
        foreach ($this->etudiant->semestre->module as $module) {
            if ($module->seance->jour == "jeudi" && $module->seance->heure == "15:00h -> 18:45h") {
                $the_module =  $the_module . $module->module;
                $salle =  " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module  . $salle;
    }

    public function getModuleVendrediMatin()
    {
        $the_module = " ";
        $salle = "";
        foreach ($this->etudiant->semestre->module as $module) {
            if ($module->seance->jour == "vendredi" && $module->seance->heure == "9:00h -> 12:45h") {
                $the_module =  $the_module . $module->module;
                $salle =  " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module   . $salle;
    }

    public function getModuleVendrediSoire()
    {
        $the_module = " ";
        $salle = "";
        foreach ($this->etudiant->semestre->module as $module) {
            if ($module->seance->jour == "vendredi" && $module->seance->heure == "15:00h -> 18:45h") {
                $the_module =  $the_module . $module->module;
                $salle =  " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module   . $salle;
    }
    public function getModuleSamediMatin()
    {
        $the_module = " ";
        $salle = "";
        foreach ($this->etudiant->semestre->module as $module) {
            if ($module->seance->jour == "samedi" && $module->seance->heure == "9:00h -> 12:45h") {
                $the_module =  $the_module . $module->module;
                $salle =  $module->seance->salle->numero;
            }
        }
        return $the_module  . $salle;
    }

    public function getModuleSamediSoire()
    {
        $the_module = " ";
        $salle = "";
        foreach ($this->etudiant->semestre->module as $module) {
            if ($module->seance->jour == "samedi" && $module->seance->heure == "15:00h -> 18:45h") {
                $the_module =  $the_module . $module->module;
                $salle =  " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module  . $salle;
    }
}