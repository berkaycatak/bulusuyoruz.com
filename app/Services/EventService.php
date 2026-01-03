<?php

namespace App\Services;

use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EventService
{
    /**
     * Create a new event.
     *
     * @param User $user
     * @param array $data
     * @return Event
     */
    public function createEvent(User $user, array $data): Event
    {
        return DB::transaction(function () use ($user, $data) {
            return $user->events()->create([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'location_mode' => $data['location_mode'],
            ]);
        });
    }
}
