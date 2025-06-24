<?php

namespace App\Http\Controllers;

use App\Models\Student_workshop;
use App\Models\Workshop_type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkshopController extends Controller
{
    public function imported(request $request){
        //return response()->json($request);
       $workshops=[];
        foreach ($request->students as $student){
         $workshops[]= Student_workshop::create([
             'name'=>$student['name'],
             'ci'=>$student['ci'],
             'code_plan'=>$student['code_plan'],
             'birthdate'=>Carbon::parse($student['birthdate'])->format('Y-m-d'),
             'code_est'=>$student['code_est'],
             'workshop_type_id'=>$request->type,
             'user_id'=>Auth::id()
         ]);

        }
       return response()->json($workshops);
    }
}
