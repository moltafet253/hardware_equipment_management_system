<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\EquipmentLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Jenssegers\Agent\Agent;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function logActivity($activity, $ip_address, $user_agent, $user_id = null)
    {
        $agent = new Agent();
        ActivityLog::create([
            'user_id' => $user_id,
            'activity' => $activity,
            'ip_address' => $ip_address,
            'user_agent' => $user_agent,
            'device' => $agent->device(),
        ]);
    }
    public function logEquipmentChanges($title, $equipment_id, $equipment_type, $user_id)
    {
        $agent = new Agent();
        EquipmentLog::create([
            'equipment_id' => $equipment_id,
            'equipment_type' => $equipment_type,
            'title' => $title,
            'user' => $user_id,
        ]);
    }

    public function alerts($state,$errorVariable,$errorText)
    {
        return response()->json([
            'success' => $state,
            'errors' => [
                $errorVariable => [$errorText]
            ]
        ]);
    }

    public function success($state,$messageVariable,$messageText)
    {
        return response()->json([
            'success' => $state,
            'message' => [
                $messageVariable => [$messageText]
            ]
        ]);
    }
}
