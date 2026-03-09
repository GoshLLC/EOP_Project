<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnimalController extends Controller
{
    // Show Page to admin & staff only
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user || !in_array($user->role, ['staff','admin'])) {
            abort(403);
        }

        $query = DB::connection('pets')
            ->table('animals')
            ->orderBy('name', 'asc');

        $animals = $query->paginate(12);

        return view('animalintake', compact('animals'));
    }

    // HANDLE FORM SUBMISSION
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user || !in_array($user->role, ['staff','admin'])) {
            abort(403);
        }

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'species'          => 'required|string',
            'breed'             => 'nullable|string|max:255',
            'age'               => 'nullable|integer|min:0',
            'sex'               => 'nullable|string|in:male,female',
            'location'          => 'nullable|string|max:255',
            'status'            => 'required|string',
            'fur_color'         => 'nullable|string',
            'sex'               => 'required|string',
            'size'               => 'nullable|string',
            'health_status'      => 'nullable|string',
            'vaccine_status'      => 'required|string|in:current,expired',
            'spayed_neutered'      => 'required|string|in:y,n',
            'intake_date'         => 'required|date',
            'image'              => 'required|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('animal_photos'), $filename);
            $validated['image'] = $filename;
        }

        DB::connection('pets')->table('animals')->insert($validated);

        return redirect()
            ->route('animals.index')
            ->with('success', 'Animal added successfully.');
    }

        public function destroy($id)
    {
        $user = auth()->user();

        // Only admin can delete
        if (!$user || $user->role !== 'admin') {
            abort(403);
        }

        DB::connection('pets')->table('animals')->where('id', $id)->delete();

        return redirect()
            ->route('animals.index')
            ->with('success', 'Animal deleted successfully.');
    }

public function edit($id)
{
    $user = auth()->user();

    if (!$user || $user->role !== 'admin') {
        abort(403);
    }

    $animal = DB::connection('pets')
        ->table('animals')
        ->where('id', $id)
        ->first();

    return view('animaledit', compact('animal'));
}

public function update(Request $request, $id)
{
    $user = auth()->user();

    if (!$user || $user->role !== 'admin') {
        abort(403);
    }

    $validated = $request->validate([
        'name'            => 'required|string|max:255',
        'species'         => 'nullable|string',
        'breed'            => 'nullable|string|max:255',
        'sex'              => 'required|string',
        'age'              => 'nullable|integer|min:0',
        'status'           => 'required|string',
        'location'         => 'nullable|string|max:255',
        'health_status'     => 'nullable|string',
        'fur_color'         => 'nullable|string',
        'size'              => 'nullable|string',
        'spayed_neutered'    => 'nullable|string',
        'vaccine_status'     => 'nullable|string',
        'intake_date'        => 'required|date',
    ]);

    DB::connection('pets')
        ->table('animals')
        ->where('id', $id)
        ->update($validated);

    return redirect()
        ->route('animals.index')
        ->with('success', 'Animal updated successfully.');
}
public function requestDeletion(Request $request, $id)
{
    $user = auth()->user();

    DB::table('animal_deletion_requests')->insert([
        'animal_id' => $id,
        'user_id'   => $user->id,
        'reason'    => $request->input('reason'),
        'status'    => 'pending'
    ]);

    return back()->with('success', 'Request submitted.');
}

public function deletionRequests()
{
    $requests = DB::table('animal_deletion_requests')
        ->where('status', 'pending')   // only show active requests
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($req) {

            // get animal from pets DB
            $animal = DB::connection('pets')
                ->table('animals')
                ->where('id', $req->animal_id)
                ->first();

            // attach animal object to request
            $req->animal = $animal;

            return $req;
        });

    return view('admin.deletion-requests', compact('requests'));
}

public function approveDeletion($id)
{
    $req = DB::table('animal_deletion_requests')->where('id', $id)->first();

    if (!$req) {
        return back()->with('info', 'Request not found.');
    }

    // delete animal from pets DB
    DB::connection('pets')->table('animals')->where('id', $req->animal_id)->delete();

    // update request status
    DB::table('animal_deletion_requests')
        ->where('id', $id)
        ->update(['status' => 'approved']);

    return back()->with('success', 'Animal deleted.');
}

public function rejectDeletion($id)
{
    DB::table('animal_deletion_requests')
        ->where('id', $id)
        ->update(['status' => 'rejected']);

    return back()->with('info', 'Request rejected.');
}

}