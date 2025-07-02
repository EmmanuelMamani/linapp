<?php

namespace App\Http\Controllers;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function index(){
        $sections = Section::where('user_id', Auth::id())
            ->with(['extracurriculars' => function($query) {
                $query->orderBy('start_date');
            }])
            ->orderBy('order')
            ->get();
        return response()->json([$sections]);
    }
    public function storeOrUpdate(Request $request)
    {
        $section = Section::updateOrCreate(
            ['id' => $request->id ?? 0],
            [
                'name' => $request->name,
                'order' => $request->order,
                'user_id' => Auth::id(),
            ]
        );

        return response()->json($section);
    }
    public function delete($id){
        Section::destroy($id);
    }
}
