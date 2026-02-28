<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');

        $results = DB::connection('pets')
            ->table('animals')
            ->where('name', 'like', "%$query%")
            ->orWhere('species', 'like', "%$query%")
            ->orWhere('breed', 'like', "%$query%")
            ->get();

        return view('search', ['results' => $results]);
    }
}