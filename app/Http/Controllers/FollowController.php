<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function toggle(User $user)
    {
        $follower = auth()->user();

        if ($user->id === $follower->id) {
            return response()->json(['status' => 'error', 'message' => 'Tidak bisa mengikuti diri sendiri'], 400);
        }

        if ($user->isFollowedBy($follower)) {
            // Unfollow
            $user->followers()->detach($follower->id);
            $isFollowing = false;
        } else {
            // Follow
            $user->followers()->attach($follower->id);
            $isFollowing = true;
        }

        return response()->json([
            'status' => 'success',
            'is_following' => $isFollowing,
        ]);
    }
}