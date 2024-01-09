<?php

namespace App\Http\Controllers\Listing;

use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activeListings = Listing::where('status', 'active')->get();
        $formattedListings = $activeListings->map(function ($listing) {
            return collect($listing)->except(['description', 'updated_at'])->all();
        });

        return response()->json(['listings' => $formattedListings], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $listing = Listing::find($id);
        if ($listing) {
            return response()->json($listing->toArray(), 200);
        } else {
            return response()->json('Listing not found', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
