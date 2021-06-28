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

class profController extends Controller
{
    public function getNoteProf(Request $request)
    {
        if ($request->role == "prof") {
            $modules = Module::where("prof_id", $request->id)->get();

            $Modules = array();
            $etudiants = array();
            $notes = array();
            foreach ($modules as $mod) {
                array_push($Modules, $mod);
                foreach ($mod->etudiants as $etu) {
                    if ($etu->noteEtudiant != null) {
                        array_push($notes, $etu->noteEtudiant);



                        foreach ($etu->noteEtudiant as $note) {
                            if ($note->note != null && $mod->id == $note->note->module_id) {
                                array_push($etudiants, (object) array('module_id' => $mod->id, 'etudiant_id' => $etu->id, 'note' => $note->note->note));
                                array_push($notes, $note->note);
                            }
                        }
                    }
                }
            }
            return response()->json([
                "modules" => $Modules,
                "notes_etudiant" => $etudiants
            ]);
        } else {
            return response()->json([
                "access" => "denied"
            ]);
        }
    }
    public function getNotificationProf(Request $request)
    {

        $reservations = Reservation::where('decision', '!=', '')->get();
        $notification = array();
        foreach ($reservations as $reservation) {
            if ($reservation->module->prof_id == $request->id) {
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
    public function saveNoteProf(Request $request)
    {
        $modules = Module::all();
        $etudiants = Etudiant::all();

        //chercher le module et l'etudiant d'apres le module_etudiant key
        $semestre = "";
        $module_id = "";
        $etudiant_id = "";
        $module = "";
        /*  $abs= array(); */
        foreach ($modules as $m) {
            foreach ($etudiants  as $e) {
                /*      array_push($abs, $m->module . $e->id); */
                if ($m->module . $e->id == $request->module_etudiant) {
                    $found = "success";
                    $etudiant_id = $e->id;
                    $module = $m->module;
                    $module_id = $m->id;
                    $semestre = $m->semestre_id;
                }
            }
        }
        //definir le niveau apartire des semestres
        if ($semestre == "1" || $semestre == "2") {
            $niveau_id = "1";
        } else if ($semestre == "3" || $semestre == "4") {
            $niveau_id = "2";
        } else if ($semestre == "5" || $semestre == "6") {
            $niveau_id = "3";
        }


        //chercher si la note existe dans la table note

        $found_note = Note::where([
            ['note', '=', $request->note],
            ['module_id', '=', $module_id]
        ])->get();

        //chercher l'etudiant a une note deja dans ce module

        $suivre_etudiant = Suivre::where([
            ['etudiant_id', '=', $etudiant_id]
        ])->get();
        $found_etudiant = null;
        foreach ($suivre_etudiant as $etudiant) {

            $note_exist =  Note::where('module_id', $module_id)->get();

            foreach ($note_exist as $note) {
                if ($note->id == $etudiant->note_id) {
                    $found_etudiant = $etudiant;
                }
            }
        }
        //si la nouvelle  note de module existe
        $note_id = "";
        if (!$found_note->isEmpty()) {
            $note_id = $found_note[0]->id;
        } else {
            //si non on cree la note          
            /* $note_id =  DB::table('notes')->insertGetId([
                'note' => $request->note,
                'module_id' => $module_id
            ]); */
            $note_id = Note::create([
                'note' => $request->note,
                'module_id' => $module_id
            ])->id;
        }



        if ($found_etudiant == null) {
            // ajoute  note et niveau et annee au etudiant si il n'a pas une note dans ce module
            Suivre::create([
                'etudiant_id' => $etudiant_id,
                'note_id' => $note_id,
                'niveau_id' =>  $niveau_id,
                'annee_id' => "1"
            ]);
        } else {
            //update si il a deja une note dans ce module
            Suivre::where("id", $found_etudiant->id)->update([
                'note_id' => $note_id
            ]);
        }



        return response()->json([
            "note_id" => $note_id
        ]);
    }

    public function getReservationProf(Request $request)
    {
        //les module de prof
        $modules_ =  Module::where('prof_id', $request->id)->get();
        $modules = array();
        foreach ($modules_ as $module) {
            array_push($modules, $module->module);
        }

        //tout les salles
        $salles_ =  Salle::all();
        $salles = array();
        foreach ($salles_ as $salle) {
            array_push($salles, $salle->numero);
        }

        return response()->json([
            "modules" => $modules,
            "salles" => $salles
        ]);
    }

    public function saveReservationProf(Request $request)
    {
        ///declaration
        $module_id = "";
        $salle_id = "";
        $seance_id = "";
        // DATE_ADD(curdate(),INTERVAL 1 WEEK)
        $module_id = Module::where('module', $request->module)->value('id');
        $salle_id = Salle::where('numero', $request->salle)->value('id');
        if ($salle_id != "") {
            $seance_id = Seance::where([
                ['jour', $request->jour],
                ['heure', $request->heure],
                ['salle_id', $salle_id]
            ])->value("id");
        }
        //after week date 
        $next_week = strtotime('next week');
        if ($request->jour == "lundi") {
            $day = "monday";
        }
        if ($request->jour == "mardi") {
            $day = "tuesday";
        }
        if ($request->jour == "mercredi") {
            $day = "wednesday";
        }
        if ($request->jour == "jeudi") {
            $day = "friday";
        }
        if ($request->jour == "vendredi") {
            $day = "saturday";
        }
        if ($request->jour == "samedi") {
            $day = "sunday";
        }

        //
        if ($seance_id != "") {
            $req = Reservation::create([
                'seance_id' => $seance_id,
                'module_id' => $module_id,
                'deleted_at' => date("Y-m-d h:i:s", strtotime($day, $next_week))
            ]);
        } else {
            $req = null;
        }

        if ($req == null) {
            $message = "probleme dans la reservation, esseyez une autre fois";
            $state = 'failed';
        } else {
            $message = "votre demande est en cour de traitement";
            $state = 'success';
        }
        return [
            'message' => $message,
            'state'  => $state
        ];
    }
    public function getEmploiProf(Request $request)
    {
        /* $etudiant = Etudiant::where([['email', '=', $request->email],[ 'date de naissance', '=', $request->date]])->get(); */
        if ($request->role == "prof") {
            $prof_ = Prof::where('id', $request->id)->get();
            $prof = Module::where(
                [
                    ['prof_id', '=', $prof_[0]->id],
                ]
            )->get();

            $emploit = new emploit_prof();
            $emploit->setUtilisateur($prof);
            $semestres = $emploit->getSemestre($request->semestres);

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

        return response()->json(["access" => "denied"]);
    }
    public function getPfeProf(Request $req)
    {
        $pfes_ = Pfe::where('prof_id', $req->id)->get();
         $pfes = array();
         foreach( $pfes_ as $pfe){
 array_push($pfes, (object) array(
                "prof" => $pfe->prof->nom . " " . $pfe->prof->prenom,
                "etudiant" => $pfe->etudiant->nom . " " . $pfe->etudiant->prenom,
                "salle" => $pfe->salle->numero,
                "sujet" => $pfe->sujet,
                "date" => $pfe->date
 ));
}
        return  response()->json([ "pfes" => $pfes]);
    }

}
class  emploit_prof
{
    private $prof;
    private $S1;
    private $S2;
    private $S3;


    public function setUtilisateur($prof)
    {
        $this->prof = $prof;
    }
    public function getNom()
    {
        return $this->prof[0]->prof->nom;
    }
    public function getSemestre($semestres)
    {
        $s1 = "";
        $s2 = "";
        $s3 = "";
        if ($semestres == "1") {
            $this->S1 = 'S1';
            $this->S2 = 'S3';
            $this->S3 = 'S5';
        } else {
            $this->S1 = 'S2';
            $this->S2 = 'S4';
            $this->S3 = 'S6';
        }
        foreach ($this->prof as $module) {

            if ($module->semestre->semestre == $this->S1) {
                $s1  =  $module->semestre->semestre;
            }
            if ($module->semestre->semestre == $this->S2) {
                $s2  =  $module->semestre->semestre;
            }
            if ($module->semestre->semestre == $this->S3) {
                $s3  =  $module->semestre->semestre;
            }
        }

        return $s1 . " " . $s2 . " " . $s3;
    }
    public function getModuleLundiMatin()
    {
        $the_module = " ";
        foreach ($this->prof as $module) {
            if ($module->seance->jour == "lundi" && $module->seance->heure == "9:00h -> 12:45h" && ($module->semestre->semestre == $this->S1 || $module->semestre->semestre == $this->S2 || $module->semestre->semestre == $this->S3)) {
                $the_module =  $the_module . $module->module." Numero du salle : " .$module->seance->salle->numero;
            }
        }
        return $the_module ;
    }

    public function getModuleLundiSoire()
    {
        $the_module = " ";
        foreach ($this->prof as $module) {
            if ($module->seance->jour == "lundi" && $module->seance->heure == "15:00h -> 18:45h" && ($module->semestre->semestre == $this->S1 || $module->semestre->semestre == $this->S2 || $module->semestre->semestre == $this->S3)) {
                $the_module =  $the_module . $module-> module . " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module;
    }

    public function getModuleMardiMatin()
    {
        $the_module = " ";
        foreach ($this->prof as $module) {
            if ($module->seance->jour == "mardi" && $module->seance->heure == "9:00h -> 12:45h" && ($module->semestre->semestre == $this->S1 || $module->semestre->semestre == $this->S2 || $module->semestre->semestre == $this->S3)) {
                $the_module =  $the_module . $module-> module . " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module;
    }

    public function getModuleMardiSoire()
    {
        $the_module = " ";
        foreach ($this->prof as $module) {
            if ($module->seance->jour == "mardi" && $module->seance->heure == "15:00h -> 18:45h" && ($module->semestre->semestre == $this->S1 || $module->semestre->semestre == $this->S2 || $module->semestre->semestre == $this->S3)) {
                $the_module =  $the_module . $module-> module . " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module;
    }
    public function getModuleMercrediMatin()
    {
        $the_module = " ";
        foreach ($this->prof as $module) {
            if ($module->seance->jour == "mercredi" && $module->seance->heure == "9:00h -> 12:45h" && ($module->semestre->semestre == $this->S1 || $module->semestre->semestre == $this->S2 || $module->semestre->semestre == $this->S3)) {
                $the_module =  $the_module . $module-> module . " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module;
    }

    public function getModuleMercrediSoire()
    {
        $the_module = " ";
        foreach ($this->prof as $module) {
            if ($module->seance->jour == "mercredi" && $module->seance->heure == "15:00h -> 18:45h" && ($module->semestre->semestre == $this->S1 || $module->semestre->semestre == $this->S2 || $module->semestre->semestre == $this->S3)) {
                $the_module =  $the_module . $module-> module . " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module;
    }
    public function getModuleJeudiMatin()
    {
        $the_module = " ";
        foreach ($this->prof as $module) {
            if ($module->seance->jour == "jeudi" && $module->seance->heure == "9:00h -> 12:45h" && ($module->semestre->semestre == $this->S1 || $module->semestre->semestre == $this->S2 || $module->semestre->semestre == $this->S3)) {
                $the_module =  $the_module . $module-> module . " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module;
    }

    public function getModuleJeudiSoire()
    {
        $the_module = " ";
        foreach ($this->prof as $module) {
            if ($module->seance->jour == "jeudi" && $module->seance->heure == "15:00h -> 18:45h" && ($module->semestre->semestre == $this->S1 || $module->semestre->semestre == $this->S2 || $module->semestre->semestre == $this->S3)) {
                $the_module =  $the_module . $module-> module . " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module;
    }

    public function getModuleVendrediMatin()
    {
        $the_module = " ";
        foreach ($this->prof as $module) {
            if ($module->seance->jour == "vendredi" && $module->seance->heure == "9:00h -> 12:45h" && ($module->semestre->semestre == $this->S1 || $module->semestre->semestre == $this->S2 || $module->semestre->semestre == $this->S3)) {
                $the_module =  $the_module . $module-> module . " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module;
    }

    public function getModuleVendrediSoire()
    {
        $the_module = " ";
        foreach ($this->prof as $module) {
            if ($module->seance->jour == "vendredi" && $module->seance->heure == "15:00h -> 18:45h" && ($module->semestre->semestre == $this->S1 || $module->semestre->semestre == $this->S2 || $module->semestre->semestre == $this->S3)) {
                $the_module =  $the_module . $module-> module . " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module;
    }
    public function getModuleSamediMatin()
    {
        $the_module = " ";
        foreach ($this->prof as $module) {
            if ($module->seance->jour == "samedi" && $module->seance->heure == "9:00h -> 12:45h" && ($module->semestre->semestre == $this->S1 || $module->semestre->semestre == $this->S2 || $module->semestre->semestre == $this->S3)) {
                $the_module =  $the_module . $module-> module . " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module;
    }

    public function getModuleSamediSoire()
    {
        $the_module = " ";
        foreach ($this->prof as $module) {
            if ($module->seance->jour == "samedi" && $module->seance->heure == "15:00h -> 18:45h" && ($module->semestre->semestre == $this->S1 || $module->semestre->semestre == $this->S2 || $module->semestre->semestre == $this->S3)) {
                $the_module =  $the_module . $module-> module . " Numero du salle : " . $module->seance->salle->numero;
            }
        }
        return $the_module;
    }
}