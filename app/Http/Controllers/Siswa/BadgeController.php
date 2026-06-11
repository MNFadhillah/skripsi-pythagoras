<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use Illuminate\Support\Facades\Auth;

class BadgeController extends Controller
{
public static function getBadgePointThresholds(): array
{
    return [
        1 => 100,
        2 => 250,
        3 => 450,
        4 => 750,
        5 => 1000,
    ];
}

    public static function checkAndAwardBadgesByPoints($user): array
    {
        $currentPoints = $user->points ?? 0;
        $thresholds = self::getBadgePointThresholds();
        $newlyEarned = [];

        $alreadyEarnedIds = $user->badges()->pluck('badges.id')->toArray();

        foreach ($thresholds as $badgeId => $requiredPoints) {
            if (in_array($badgeId, $alreadyEarnedIds)) {
                continue;
            }

            if ($currentPoints >= $requiredPoints) {
                $badge = Badge::find($badgeId);

                if ($badge) {
                    $user->badges()->syncWithoutDetaching([$badgeId]);

                    $newlyEarned[] = [
                        'name'  => $badge->name,
                        'image' => asset('images/badges/' . $badge->image_path),
                    ];
                }
            }
        }

        return $newlyEarned;
    }

    public function index()
    {
        $user = Auth::user();

        $allBadges = Badge::all();
        $earnedBadgeIds = $user->badges->pluck('id')->toArray();

        return view('badges.index', compact('allBadges', 'earnedBadgeIds'));
    }
}