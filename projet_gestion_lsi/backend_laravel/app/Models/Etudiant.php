<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Etudiant/*  extends model */ extends  Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    protected $fillable = ["nom","prenom","cne", "date_de_naissance","semestre_id"];
    protected $table = "etudiants";
    public function semestre()
    {
        return $this->belongsTo(Semestre::class,);
    }
    public function noteEtudiant()
    {
        return $this->hasMany(Suivre::class);
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
}
