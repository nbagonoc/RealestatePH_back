<?php

namespace App\Http\Controllers\Like;

use App\Models\Like;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    /**
     * Like a specific listing.
     */
    public function likeListing(string $listingId)
    {
        $user = auth()->user();
        $listing = Listing::find($listingId);

        if (!$listing) {
            return response()->json(['message' => 'Listing not found'], 404);
        }

        // Check if the user has already liked the listing
        /** @var \App\Models\User $user */
        if ($user->likedListings()->where('listing_id', $listingId)->exists()) {
            return response()->json(['message' => 'Listing already liked'], 400);
        }

        $user->likedListings()->attach($listingId);

        return response()->json(['message' => 'Listing liked'], 200);
    }


    /**
     * get all liked listings by the user.
     */
    public function likedListings()
    {
        $user = auth()->user();
        /** @var \App\Models\User $user */
        $likedListings = $user->likedListings;

        if ($likedListings->isEmpty()) {
            return response()->json(['message' => 'No liked listings found'], 404);
        }

        $formattedListings = $likedListings->map(function ($listing) {
            return collect($listing)->except(['description', 'updated_at'])
                ->merge([
                    'category' => $listing->category->name,
                    'type' => $listing->type->name,
                    'status' => $listing->status->name,
                ])
                ->forget(['category_id', 'type_id', 'status_id', 'pivot']);
        });

        return response()->json($formattedListings, 200);
    }


    /**
     * Unlike a specific listing.
     */
    public function unlikeListing(string $listingId)
    {
        $user = auth()->user();

        // Retrieve the like record for the specific listing by the authenticated user
        $like = Like::where('user_id', $user->id)->where('listing_id', $listingId)->first();

        if (!$like) {
            return response()->json(['message' => 'Listing not found in liked listings'], 404);
        }

        $like->delete();

        return response()->json(['message' => 'Listing unliked'], 200);
    }
}
