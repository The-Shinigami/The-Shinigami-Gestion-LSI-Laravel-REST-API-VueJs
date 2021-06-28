<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
   protected $fillable = ['seance_id','module_id','deleted_at'];
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    public function seance()
    {
        return $this->belongsTo(Seance::class,);
    }
}
