<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $guarded = [];
    public function extracurriculars(){
        return $this->belongsToMany(Extracurricular::class, 'extracurricular_sections')
            ->withTimestamps()
            ->orderBy('start_date');
    }
}
