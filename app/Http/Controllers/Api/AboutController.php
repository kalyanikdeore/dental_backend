<?php

namespace App\Http\Controllers\Api;

use App\Models\AboutStory;
use App\Models\VisionMission;
use App\Models\TeamMember;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function getStory()
    {
        $story = AboutStory::where('visible', true)
            ->orderBy('order')
            ->first();
            
        return response()->json($story);
    }

    public function getVisionMission()
    {
        $visionMission = VisionMission::where('visible', true)->first();
        return response()->json($visionMission);
    }

    public function getTeamMembers()
    {
        $teamMembers = TeamMember::where('visible', true)
            ->orderBy('order')
            ->get();
            
        return response()->json($teamMembers);
    }
}