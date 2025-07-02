<?php

namespace App\Http\Controllers;

use App\Models\Extracurricular;
use App\Models\extracurricular_section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExtracurricularController extends Controller
{
    public function create(Request $request){

        $extracurricular = Extracurricular::create([
            'titulo' => $request->title,
            'institution'=>$request->institution,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'active'=>true,
            'user_id'=>Auth::id(),
            'topic_id'=>$request->topic_id,
            'status'=>'Finalizado'
        ]);
        $this->assign($extracurricular->id,$request->section);
        return response()->json([$extracurricular]);
    }
    public function assign($extracurricular_id,$section_id){
        Extracurricular_section::where('extracurricular_id',$extracurricular_id)->delete();
        Extracurricular_section::create([
            'extracurricular_id'=>$extracurricular_id,
            'section_id'=>$section_id
        ]);
    }
    public function delete($id){
        Extracurricular::destroy($id);
    }
    public function active($id){
        $extracurricular=Extracurricular::find($id);
        $extracurricular->active=!$extracurricular->active;
        $extracurricular->save();
    }
    public function update($id,Request $request){
        $extracurricular=Extracurricular::find($id);
        $extracurricular::update([
            'titulo' => $request->title,
            'institution'=>$request->institution,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'topic_id'=>$request->topic_id,
        ]);
        $extracurricular->save();
        return response()->json([$extracurricular]);
    }
}
