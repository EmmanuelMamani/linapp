<?php

namespace App\Http\Controllers;

use App\Models\Age;
use Illuminate\Http\Request;

class AgeCotroller extends Controller
{
    public function index(){
        $ages = Age::orderBy('name')->get();
        return response()->json($ages);
    }
}
