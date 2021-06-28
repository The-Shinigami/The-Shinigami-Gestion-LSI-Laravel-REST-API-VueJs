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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class authController extends Controller
{
    
    public function login(Request $request)
    {
        //partie etudiant
        if ($request->date_de_naissance != "" && $request->cne != "") {
            $credentials =[
                "cne" => $request->cne,
                "date_de_naissance" => $request->date_de_naissance,
            ];
            $token = Auth::guard('etudiant-api')->attempt($credentials);
            if (!$token)
                return response()->json(['erreur' => 'information incorrect',
                'logged' => 'failed']);
            $utilisateur= Auth::guard('etudiant-api')->user();
            //notification counter
            $reservations = Reservation::where('decision', 'accepter')->get();
            $semestre_id = Etudiant::where('id', $utilisateur->id)->value('semestre_id');
            $notification = array();
            foreach ($reservations as $reservation) {
                if ($reservation->module->semestre_id == $semestre_id) {
                    array_push($notification, (object) array(
                        "module" => $reservation->module, "seance" => $reservation->seance,
                        "salle" => $reservation->seance->salle, "decision" =>  $reservation->decision
                    ));
                }
            }
             $counter = count($notification);

            //return token
            return response()->json([
                "id" => $utilisateur->id,
                "role" => "etudiant",
                "full_name" => $utilisateur->nom . " " . $utilisateur->prenom,
                'logged' => 'success',
                "token" => $token,
                "counter" => $counter
            ]);
        }
         //partie prof and admin
        if ($request->login != "" && $request->password != "") {
            $credentials = [
                "login" => $request->login,
                "password" => $request->password,
            ];
            $token_prof = Auth::guard('prof-api')->attempt($credentials, ['exp' => Carbon::now()->addDays(1)->timestamp]);
            $token_admin = Auth::guard('admin-api')->attempt($credentials, ['exp' => Carbon::now()->addDays(1)->timestamp]);

            if (!$token_prof)
                {
                if (!$token_admin) {
                  
                    return response()->json( [
                        'erreur' => 'information incorrect',
                        'logged' => 'failed'
                    ]);
                }  
                else{
                    $token = $token_admin;
                    $role="admin";
                    $utilisateur = Auth::guard('admin-api')->user();
                    $counter_prof="";
                }
                }
                else{
                $token = $token_prof;
                $role = "prof";
                $utilisateur = Auth::guard('prof-api')->user();
                $reservations = Reservation::where('decision','!=','')->get();
                $notification = array();
                foreach ($reservations as $reservation) {
                    if ($reservation->module->prof_id == $utilisateur->id) {
                        array_push($notification, (object) array(
                            "module" => $reservation->module, "seance" => $reservation->seance,
                            "salle" => $reservation->seance->salle, "decision" =>  $reservation->decision
                        ));
                    }
                }
                $counter_prof = count($notification);
                }
               
            //return token
            return response()->json([
                "id" => $utilisateur->id,
                "role" => $role,
                "full_name" => $utilisateur->nom ." ". $utilisateur->prenom,
                'logged' => 'success',
                "token" => $token,
                "counter_prof" => $counter_prof
            ]);
        }

       
    }

}