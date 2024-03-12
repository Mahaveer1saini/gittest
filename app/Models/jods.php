<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jods extends Model
{
    use HasFactory;




    public function jodtype(){
        return $this->belongsTo(Jodtype::class);
    }

    public function categories(){
        return $this->belongsTo(categories::class);
    }

    	
}
