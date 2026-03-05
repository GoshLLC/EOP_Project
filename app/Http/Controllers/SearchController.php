<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q = trim($request->input('q', ''));
        $species = trim($request->input('species', ''));
        $location = trim($request->input('location', ''));
        $age = $request->input('age');
        $sex = trim($request->input('sex', ''));
        $breed = trim($request->input('breed', ''));
        $status = trim($request->input('status', ''));
        $healthStatus = trim($request->input('health_status', ''));
        $intakeFrom = $request->input('intake_date_from');
        $intakeTo   = $request->input('intake_date_to');
        $furColor = trim($request->input('fur_color', ''));
        $size = trim($request->input('size', ''));
        $sort = strtolower($request->input('sort', 'asc'));
        $vaccineStatus = trim($request->input('vaccine_status', ''));
    
        // Role Variables
        $user = auth()->user();
        $role = $user ? $user->role : null;
        $privilegedRoles = ['staff', 'admin', 'volunteer'];
        $isPrivileged = in_array($role, $privilegedRoles, true);
    
        $perPage = $request->input('per_page', 12);
        $page    = $request->input('page', 1);

        // Build query
        $query = DB::connection('pets')
            ->table('animals')
            ->select([
                'id',
                'name',
                'species',
                'breed',
                'age',
                'status',
                'intake_date',
                'image',
                'location',
                'health_status',
                'intake_date',
                'fur_color',
                'size',
                'sex',
                'vaccine_status',
                'spayed_neutered'
            ]);

        // Users and Public Only
        if (!$isPrivileged) {$query->whereRaw('LOWER(TRIM(status)) = ?', ['available']);
        }

        // Privileged filters
        if ($isPrivileged) {
            if ($status !== '') {$query->whereRaw('LOWER(TRIM(status)) = ?', [strtolower($status)]);}

            if ($healthStatus !== '') {$query->whereRaw('LOWER(TRIM(COALESCE(health_status,""))) = ?', [strtolower($healthStatus)]);}

            if ($vaccineStatus !== '') {$query->whereRaw('LOWER(TRIM(COALESCE(vaccine_status,""))) = ?', [strtolower($vaccineStatus)]);}

            if (!empty($intakeFrom)) {$query->where('intake_date', '>=', $intakeFrom);}

            if (!empty($intakeTo)) {$query->where('intake_date', '<=', $intakeTo);}
        }

    // Additional filters
    if ($species !== '') {$query->whereRaw('LOWER(TRIM(COALESCE(species,""))) = ?', [strtolower($species)]);}

    if ($location !== '') {
        $query->whereRaw('LOWER(COALESCE(location,"")) LIKE ?', ['%' . strtolower($location) . '%']);
    }

    if ($age !== null && is_numeric($age)) {$query->where('age', (int)$age);}

    if ($sex !== '') {$query->whereRaw('LOWER(TRIM(COALESCE(sex,""))) = ?', [strtolower($sex)]);}

    if ($breed !== '') {$query->whereRaw('LOWER(TRIM(COALESCE(breed,""))) = ?', [strtolower($breed)]);}

    if ($furColor !== '') {$query->whereRaw('LOWER(TRIM(COALESCE(fur_color,""))) = ?', [strtolower($furColor)]);}

    if ($size !== '') {$query->whereRaw('LOWER(TRIM(COALESCE(size,""))) = ?', [strtolower($size)]);}

    if ($q !== '') {
        $query->where(function ($sub) use ($q) {
            $sub->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($q) . '%'])
                ->orWhereRaw('LOWER(species) LIKE ?', ['%' . strtolower($q) . '%'])
                ->orWhereRaw('LOWER(breed) LIKE ?', ['%' . strtolower($q) . '%'])
                ->orWhereRaw('LOWER(location) LIKE ?', ['%' . strtolower($q) . '%']);
        });
    }

        // Order of Results
        switch ($sort) {
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            
            case 'age_asc':
                $query->orderBy('age', 'asc');
                break;
            
            case 'age_desc':
                $query->orderBy('age', 'desc');
                break;
            
            default:
                $query->orderBy('name', 'asc');
        }

        // Pagination
        $results = $query->paginate($perPage)->appends($request->query());

        // AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'html'       => view('search.partials.results', compact('results'))->render(),
                'total'      => $results->total(),
                'pagination' => $results->links()->toHtml(),
            ]);
        }

        return view('search', compact('results'));
    }
}