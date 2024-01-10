<?php

namespace App\Http\Controllers\Listing;

use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ListingRequest;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activeListings = Listing::where('status_id', 1)->get(); //active listings

        $formattedListings = $activeListings->map(function ($listing) {
            return collect($listing)->except(['description', 'updated_at'])
            ->merge([
                'category' => $listing->category->name,
                'type' => $listing->type->name,
                'status' => $listing->status->name,
                ])
            ->forget(['category_id', 'type_id', 'status_id']);
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
    public function store(ListingRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        Listing::create($data);

        return response()->json(['message' => 'Listing created'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $listing = Listing::with(['category', 'status', 'type'])->find($id);

        if ($listing) {
            $formattedListing = collect($listing)->forget(['category_id', 'type_id', 'status_id']);
            return response()->json($formattedListing, 200);
        } else {
            return response()->json(['message' => 'Listing not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ListingRequest $request, String $id)
    {
        $listing = Listing::find($id);

        if (!$id) {
            return response()->json(['message' => 'Listing not found'], 404);
        }

        $data = $request->validated();

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

    /**
     * Patch specific fields(status, category and type) of a resource.
     */
    public function updateField(Request $request, String $id)
    {
        $listing = Listing::find($id);
    
        if (!$listing) {
            return response()->json(['message' => 'Listing not found'], 404);
        }
    
        $validations = [
            'status_id' => 'exists:statuses,id',
            'category_id' => 'exists:categories,id',
            'type_id' => 'exists:types,id',
        ];
    
        $field = $request->validate($validations);
    
        $fieldToUpdate = collect($field)->filter()->keys()->first();
    
        if (!$fieldToUpdate) {
            return response()->json(['message' => 'At least one field is required'], 400);
        }
    
        $listing->update($field);
    
        $fieldNames = [
            'status_id' => 'status',
            'category_id' => 'category',
            'type_id' => 'type',
        ];
    
        $fieldName = $fieldNames[$fieldToUpdate];
    
        return response()->json(['message' => "Listing $fieldName updated"], 200);
    }
}
