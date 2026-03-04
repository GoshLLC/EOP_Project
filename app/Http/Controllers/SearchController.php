<?php
// app\Http\Controllers\SearchController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q = trim($request->input('q', ''));
        $species   = trim($request->input('species', ''));
        $location  = trim($request->input('location', ''));
        $age       = $request->input('age');
        $sex       = trim($request->input('sex', ''));
        $status    = trim($request->input('status', ''));
    
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
            ->select(['id', 'name', 'species', 'breed', 'age', 'status', 'intake_date', 'image', 'location']);

        // Users and Public Only
        if (!$isPrivileged) {
            $query->whereRaw('LOWER(TRIM(status)) = ?', ['available']);
        }
        // Staff/admin can filter by status
        elseif ($status !== '') {
            $query->whereRaw('LOWER(TRIM(status)) = ?', [strtolower($status)]);
        }

        // Case insensitivity
        if ($q !== '') {
            $term = '%' . $q . '%';
            $query->where(function ($sub) use ($term) {
                $sub->whereRaw('LOWER(name) LIKE ?', [$term])
                    ->orWhereRaw('LOWER(COALESCE(species,"")) LIKE ?', [$term])
                    ->orWhereRaw('LOWER(COALESCE(breed,"")) LIKE ?', [$term]);
            });
        }

        // Additional filters
        if ($species !== '') {
            $query->whereRaw('LOWER(TRIM(COALESCE(species,""))) = ?', [strtolower($species)]);
        }

        if ($location !== '') {
            $query->whereRaw('LOWER(COALESCE(location,"")) LIKE ?', ['%' . strtolower($location) . '%']);
        }

        if ($age !== null && is_numeric($age)) {$query->where('age', (int)$age);}

        // if ($sex !== '') {$query->whereRaw('LOWER(TRIM(COALESCE(sex,""))) = ?', [strtolower($sex)]);}

        // Order of Results
        $query->orderBy('name', 'asc');

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