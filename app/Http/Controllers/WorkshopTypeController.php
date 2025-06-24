<?php

namespace App\Http\Controllers;

use App\Models\Workshop_type;
use Illuminate\Http\Request;

class WorkshopTypeController extends Controller
{
    public function index(){
        $workshopTypes = Workshop_type::orderBy('name')->get();
        return response()->json($workshopTypes);
    }
}
