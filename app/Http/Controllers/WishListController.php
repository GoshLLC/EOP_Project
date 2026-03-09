<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class WishListController extends Controller
{
    public function store($id)
    {
        $userId = auth()->id();

        $exists = DB::table('wishlists')
            ->where('user_id', $userId)
            ->where('animal_id', $id)
            ->exists();

        if ($exists) {
            return back()->with('info', 'Already in wishlist.');
        }

        DB::table('wishlists')->insert([
            'user_id' => $userId,
            'animal_id' => $id
        ]);

        return back()->with('success', 'Added to wishlist!');
    }

    public function destroy($id)
    {
        DB::table('wishlists')
            ->where('user_id', auth()->id())
            ->where('animal_id', $id)
            ->delete();

        return back()->with('info', 'Removed from wishlist.');
    }

    public function index()
    {
        $ids = DB::table('wishlists')
            ->where('user_id', auth()->id())
            ->pluck('animal_id');

        $animals = DB::connection('pets')
            ->table('animals')
            ->whereIn('id', $ids)
            ->get();

        return view('wishlist', compact('animals'));
    }
}