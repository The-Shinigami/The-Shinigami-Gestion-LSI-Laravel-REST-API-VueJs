<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable =['note','module_id'];
    use HasFactory;
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    
   
}
