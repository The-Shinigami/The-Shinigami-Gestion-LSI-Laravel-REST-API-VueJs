<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pfe extends Model
{
    use HasFactory;
   protected $table="pfes";
    protected $fillable = [
        'sujet',
        'date',
        'salle_id',
        'etudiant_id',
        'prof_id'
    ];
    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function prof()
    {
        return $this->belongsTo(prof::class);
    }
}
