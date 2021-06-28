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
use Illuminate\Http\Request;

class adminController extends Controller
{
    public function getReservationAdmin(Request $request)
    {
        if ($request->role == "admin") {
            $reservations = Reservation::where('decision', '')->get();
        }

        $reservation_demandes = array();
        foreach ($reservations as $reservation) {
            if ($reservation->module->semestre->semestre == "S1" || $reservation->module->semestre->semestre == "S3" || $reservation->module->semestre->semestre == "S5") {
                $module =  Module::where([
                    ['semestre_id', '!=', 2],
                    ['semestre_id', '!=', 4],
                    ['seance_id', $reservation->seance->id],

                ])->get();
                $reserver = Reservation::where([
                    ['seance_id', $reservation->seance->id],
                    ['decision', "accepter"]
                ])->get();
            } else {
                $module =  Module::where([
                    ['semestre_id', '!=', 1],
                    ['semestre_id', '!=', 3],
                    ['semestre_id', '!=', 5],
                    ['seance_id', $reservation->seance->id],

                ])->get();
                $reserver = Reservation::where([
                    ['seance_id', $reservation->seance->id],
                    ['decision', "accepter"]
                ])->get();
            }
            if ($module->isEmpty() && $reserver->isEmpty()) {
                $state = 'valable';
            } else {
                $state = 'invalable';
            }

            array_push($reservation_demandes, (object) array(
                "module" => $reservation->module, "seance" => $reservation->seance,
                "salle" => $reservation->seance->salle, "prof" => $reservation->module->prof, "state" => $state, "id" => $reservation->id
            ));
        }






        return [
            "reservation_demandes" =>  $reservation_demandes
        ];
    }

    public function saveReservationAdmin(Request $request)
    {
        $req = Reservation::where('id', $request->id)->update([
            "decision" => $request->decision
        ]);
        return [
            "req"  => $req
        ];
    }

    public function getEmploiAdmin(Request $request)
    {

        if ($request->role == "admin") {
            $etudiant = Etudiant::where('semestre_id', $request->semestre_id)->first();
            $emploit = new emploit();
            $emploit->setUtilisateur($etudiant);
            $semestres = $emploit->getSemestre();
            return  [
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
            ];
        }

        return ["access" => "denied"];
    }

    public function addEtudiant(Request $request)
    {


        if ($request->role == "admin") {

            Etudiant::create([
                "nom" => $request->nom,
                "prenom" => $request->prenom,
                "cne" => $request->cne,
                "date_de_naissance" => $request->date_de_naissance,
                "semestre_id" => $request->semestre
            ]);

            return ["state" => "success"];
        }

        return ["state" => "failed"];
    }

    public function updateEtudiant(Request $request)
    {
        if ($request->role == "admin") {

            Etudiant::where('id', $request->id)->update([
                "nom" => $request->nom,
                "prenom" => $request->prenom,
                "cne" => $request->cne,
                "date_de_naissance" => $request->date_de_naissance,
                "semestre_id" => $request->semestre_id
            ]);

            return ["state" => "success"];
        }

        return ["state" => "failed"];
    }
    public function deleteEtudiant(Request $request)
    {
        $req = Etudiant::where('id', $request->id)->delete();
        if ($req) {
            return ["state" => "success"];
        } else {
            return [
                "state" => "failed",
                "id" => $request->id
            ];
        };
    }
    public function getAllEtudiant(Request $request)
    {

        if ($request->role == "admin") {
            return ["etudiants" => Etudiant::all()];
        }
        return ["state" => "denied"];
    }

    public function getAllPfe()
    {
        $etudiants_ = Etudiant::all();
        $profs_ = Prof::all();
        $salles_ = Salle::all();
        $pfes_ =Pfe::all();
        //********************************* */
        $etudiants = array();
        $profs = array();
        $salles = array();
        $ids = array();

        $exist= true;
            foreach ($etudiants_ as $etudiant) {
            
            if( $etudiant->semestre_id == "6")
               {
                foreach ($pfes_ as $pfe) {       
                  if($etudiant->id == $pfe->etudiant_id) {
                      $exist = false;
                    array_push($ids, (object) array($etudiant->nom => $etudiant->id . "==" . $pfe->etudiant_id));
                  }
                }
                if ($exist) {
                    array_push($etudiants, (object) array("etudiant" => $etudiant->cne . " " . $etudiant->nom . " " . $etudiant->prenom, "etudiant_id" => $etudiant->id));
                }

                $exist = true;  
        }
            
           
        }
        foreach($profs_ as $prof){
            array_push($profs, (object) array("prof" => $prof->nom . " " . $prof->prenom ,"prof_id" => $prof->id));
        }
        foreach ($salles_ as $salle) {
            array_push($salles, (object) array("salle" => $salle->numero,"salle_id"=> $salle->id));
        }

        return  [
                'etudiants' => $etudiants,
                'profs' => $profs,
                'salles' => $salles,
                "ids" => $ids
            ]
        ;
    }
    public function setPfe(Request $request)
    { 
        $req= Pfe::create([
            'sujet' =>  $request->sujet,
            'date' =>  $request->date,
            'salle_id' =>   $request->salle_id,
            'etudiant_id' =>  $request->etudiant_id,
            'prof_id' =>  $request->prof_id

        ]);
          if($req){
            return ["state" => "success"];
          }else{
            return ["state" => "failed"]; 
          };
    }
    public function updatePfe(Request $request)
    {
        $req = Pfe::where('id', $request->id)->update([
            'sujet' =>  $request->sujet,
            'date' =>  $request->date,
        ]);
        if ($req) {
            return ["state" => "success"];
        } else {
            return ["state" => "failed"];
        };
    }
    public function deletePfe(Request $request)
    {
        $req = Pfe::where('id', $request->id)->delete();
        if ($req) {
            return ["state" => "success"];
        } else {
            return ["state" => "failed",
         "id"=> $request->id];
        };
    }
    public function getEmploi(Request $req)
    {
        if ($req->role == "admin") {
            $modules_ = Module::all();
            $modules = array();
            foreach ($modules_ as $module) {
                array_push($modules, (object)array(
                    'id' => $module->id,
                    'module' => $module->module,
                    'jour' => $module->seance->jour,
                    'heure' => $module->seance->heure,
                    'salle' => $module->seance->salle->numero
                ));
            }


            return  ["emplois" => $modules];
        }

        return ["state" => "failed"];
    }
    public function UpdateEmploi(Request $req)
    {
        if ($req->role == "admin") {
            $salle= Salle::where('numero',$req->salle)->first();

            $seance = Seance::where([["jour",$req->jour],["heure",$req->heure],["salle_id",$salle->id]])->first();

            $reservation = Reservation::where([['decision', 'accepter'],['seance_id',$seance->id]])->get();

            $module_= Module::where('id',$req->id)->get();

            if(!$module_->isEmpty()){
             if($module_[0]->semestre->semestre == "S1" || $module_[0]->semestre->semestre == "S3" || $module_[0]->semestre->semestre == "S5")
             {
                    $module = Module::where([
                        ['semestre_id', '!=', 2],
                        ['semestre_id', '!=', 4], 
                        ['seance_id', $seance->id]])->get();
             }else{
                    $module = Module::where([
                        ['semestre_id', '!=', 1],
                        ['semestre_id', '!=', 3],
                        ['semestre_id', '!=', 5],
                        ['seance_id', $seance->id]
                    ])->get();        
             }

                if ($module->isEmpty() && $reservation->isEmpty()) {
                    Module::where("id", $req->id)->update([
                        "seance_id" => $seance->id
                    ]);
                    return ["state" => "success", "module" => $module->isEmpty(), "reservation" => $reservation->isEmpty()];
                } else {
                    return ["state" => "occupé", "module" => $module->isEmpty(), "reservation" => $reservation->isEmpty()];
                }
            }
            
          
         
    }
       /* return ["ee" => $req->jour]; */
        return ["state" => "failed"];
    } 
    public function getPfeAdmin(Request $req)
    {
        if($req->role == "admin"){
            $pfes_ = Pfe::all();
            $pfes = array();
            foreach ($pfes_ as $pfe) {
                array_push($pfes, (object) array(
                    "id" => $pfe->id,
                    "prof" => $pfe->prof->nom . " " . $pfe->prof->prenom,
                    "etudiant" => $pfe->etudiant->nom . " " . $pfe->etudiant->prenom,
                    "salle" => $pfe->salle->numero,
                    "sujet" => $pfe->sujet,
                    "date" => $pfe->date
                ));
            }
            return  ["pfes" => $pfes];
        }

        return ["state" => "failed","role" => $req->role];
      
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
        $salle = "";
        foreach ($this->etudiant->semestre->module as $module) {

            if ($module->seance->jour == "lundi" && $module->seance->heure == "9:00h -> 12:45h") {

                $the_module =  $the_module . $module->module;
                $salle =  " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module   . $salle;
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