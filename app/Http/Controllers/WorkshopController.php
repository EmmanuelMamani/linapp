<?php

namespace App\Http\Controllers;

use App\Models\Age;
use App\Models\Student_workshop;
use App\Models\Workshop_type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkshopController extends Controller
{
    public function imported(request $request){
        $age = Age::where('active',true)->first();
       $workshops=[];
        foreach ($request->students as $student){
            $existStudent=Student_workshop::where('ci',$student['ci'])
                                            ->where('age_id',$age->id)
                                            ->where('workshop_type_id',$request->type)
                                            ->exists();
            if(!$existStudent){
                $workshops[]= Student_workshop::create([
                    'name'=>$student['name'],
                    'ci'=>$student['ci'],
                    'code_plan'=>$student['code_plan'],
                    'birthdate'=>Carbon::parse($student['birthdate'])->format('Y-m-d'),
                    'code_est'=>$student['code_est'],
                    'workshop_type_id'=>$request->type,
                    'user_id'=>Auth::id(),
                    'age_id'=>$age->id
                ]);
            }
        }
        return response()->json($workshops);
    }
    public function delete($id){
        $workshop = Student_workshop::find($id);
        $workshop->delete();
    }
}
