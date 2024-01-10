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
            return collect($listing)->except(['description', 'updated_at'])
            ->merge(['category' => $listing->category->name])
            ->forget(['category_id']);
        });

        //check if formattedListings is empty
        if (!$formattedListings->isEmpty()) {
            return response()->json($formattedListings, 200);
        } else {
            return response()->json(['message' => 'No listings found'], 404);
        }
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
        // $listing = Listing::find($id);
        $listing = Listing::with('category')->find($id);

        if ($listing) {
            // return response()->json($listing->toArray(), 200);
            
            // $formattedListing = collect($listing)
            //     ->merge(['category' => $listing->category->name])
            //     ->forget(['category_id']);

            $formattedListing = collect($listing)->forget(['category_id']);
            $formattedListing['category'] = $listing->category;

            return response()->json($formattedListing, 200);
        } else {
            return response()->json(['message' => 'Listing not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        if (!$listing) {
            return response()->json(['message' => 'Listing not found'], 404);
        }

        $data = $request->validate([
            'status' => 'required|string|in:active,pending,closed',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string|size:2',
            'zip' => 'required|string|size:5',
            'photo' => 'required|string',
            'category' => 'required|string|in:house,condo,townhouse,apartment,land,commercial',
            'type' => 'required|string|in:sale,rent',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'sqft' => 'required|numeric',
            'lot_size' => 'required|numeric',
            'year_built' => 'required|integer',
            'parking' => 'required|integer',
        ]);

        $listing->update($data);

        return response()->json(['message' => 'Listing updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $listing = Listing::find($id);

        if (!$listing) {
            return response()->json(['message' => 'Listing not found'], 404);
        }

        $listing->delete();

        return response()->json(['message' => 'Listing deleted'], 200);
    }
}
