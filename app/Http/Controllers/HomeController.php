<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudy;
use App\Models\Thesis;
use App\Models\ThesisCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function welcomeView()
    {
        return view('public_views.welcome');
    }

    public function homeView(Request $request)
    {
        // dd($request->all());
        $searchParams = [
            'title' => $request->title,
            'id_program_study' => $request->id_program_study,
            'id_category' => $request->id_category,
            'name' => $request->author,
            'publication_from' => $request->publication_from ? Carbon::createFromDate($request->publication_from, 1)->startOfYear() : null,
            'publication_until' => $request->publication_until ? Carbon::createFromDate($request->publication_until, 1)->endOfYear() : null,
        ];
        
        $thesis = DB::table('thesis as t')
        ->where('t.title', 'like', '%'.$searchParams['title'].'%')
        ->when($searchParams['id_category'], function($query) use ($searchParams){
            return $query->whereIn('t.id_category', $searchParams['id_category']);
        })
        ->when($searchParams['id_program_study'], function($query) use ($searchParams){
            return $query->whereIn('u.id_program_study', $searchParams['id_program_study']);
        })
        ->when($searchParams['name'], function($query) use ($searchParams){
            return $query->where('u.name', $searchParams['name']);
        })
        ->when($searchParams['publication_from'], function($query) use ($searchParams){
            return $query->where('t.created_at', '>=',$searchParams['publication_from']);
        })
        ->when($searchParams['publication_until'], function($query) use ($searchParams){
            return $query->where('t.created_at', '<=',$searchParams['publication_until']);
        })
        ->join('users as u', 'u.id', 't.id_user')
        ->join('program_study as ps', 'ps.id', 'u.id_program_study')
        ->selectRaw('t.id as thesis_id, u.id as user_id, u.name as user_name, t.title as thesis_title, t.abstract as thesis_abstract, ps.name as program_study_name')
        ->orderBy('t.id', 'desc')
        ->paginate(5);

        $categories = ThesisCategory::all();

        $prodys = ProgramStudy::all();
            
        return view('public_views.home', ['thesis' => $thesis, 'categories' => $categories, 'prodys' => $prodys]);
    }

    public function getSuggestionTitle( Request $request)
    {
        $searchInput = $request->title;

        $titles = Thesis::select('title')->where('title', 'like', '%'.$searchInput.'%')->get();

        return response()->json($titles);
    }

    public function getSuggestionAuthor( Request $request)
    {
        $searchInput = $request->title;

        $titles = User::select('name')->where('name', 'like', '%'.$searchInput.'%')->get();

        return response()->json($titles);
    }
}
