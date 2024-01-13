<?php

namespace App\Http\Controllers\Review;

use App\Models\Review;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function storeReview(Request $request, $profile_id)
    {
        $user_id = auth()->user()->id;
        $profile = Profile::find($profile_id);

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }
        if ($user_id == $profile->user_id) {
            return response()->json(['message' => 'You cannot review your own profile'], 400);
        }
        if (Review::where('user_id', $user_id)->where('profile_id', $profile_id)->exists()) {
            return response()->json(['message' => 'You have already reviewed this profile'], 400);
        }
        if (auth()->user()->role == "user" && $profile->user->role == "user") {
            return response()->json(['message' => 'You cannot review this profile'], 400);
        }

        $data = $request->validate([
            'rate' => 'required|numeric|min:1|max:5',
            'review' => 'required|string|max:255',
        ]);

        Review::create($data + ['user_id' => $user_id, 'profile_id' => $profile_id]);

        return response()->json([
            'message' => 'Your review has been submitted!',
        ]);
    }

    public function viewReview($id)
    {
        $review = Review::find($id);

        return $review
            ? response()->json($review, 200)
            : response()->json(['message' => 'Review not found'], 404);
    }

    public function listReviews($profile_id)
    {
        $reviews = Review::where('profile_id', $profile_id)->get();

        return $reviews
            ? response()->json($reviews, 200)
            : response()->json(['message' => 'No reviews found'], 404);
    }

    public function updateReview(Request $request, $id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $data = $request->validate([
            'rate' => 'required|numeric|min:1|max:5',
            'review' => 'required|string|max:255',
        ]);

        $review->update($data);

        return response()->json([
            'message' => 'Your review has been updated!',
        ]);
    }

    public function destroyReview($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->delete();

        return response()->json([
            'message' => 'Your review has been deleted!',
        ]);
    }
}
