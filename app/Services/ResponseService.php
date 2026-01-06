<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Response;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ResponseService
{
    public function createResponse(Event $event, ?User $user, array $data, ?string $ip): Response
    {
        return DB::transaction(function () use ($event, $user, $data, $ip) {
            // Check if user already responded? 
            // For now, we allow multiple responses or maybe we should check.
            // Requirement says "security best practices", preventing spam is one.
            // But basic flow first.

            return $event->responses()->create([
                'user_id' => $user?->id,
                'ip_address' => $ip,
                'email' => $data['email'] ?? null,
                'location_answer' => $data['location_answer'] ?? null,
                'province_id' => $data['province_id'],
                'district_id' => $data['district_id'],
                'selected_dates' => $data['selected_dates'],
                'selected_times' => $data['selected_times'],
            ]);
        });
    }
}
