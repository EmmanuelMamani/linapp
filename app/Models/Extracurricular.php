<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    protected $guarded = [];

    public function sections(){
        return $this->belongsToMany(Section::class, 'extracurricular_sections')
            ->withTimestamps();
    }

}
