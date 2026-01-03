<?php

namespace App\ViewModels;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;

class EventViewModel
{
    public function __construct(
        public Event $event,
        public ?User $currentUser = null
    ) {}

    public function isOwner(): bool
    {
        return $this->currentUser && $this->currentUser->id === $this->event->user_id;
    }

    public function shareUrl(): string
    {
        return route('events.show', $this->event->slug);
    }

    public function formattedDateRange(): string
    {
        $start = Carbon::parse($this->event->start_date)->translatedFormat('d F');
        $end = Carbon::parse($this->event->end_date)->translatedFormat('d F Y');
        
        return "{$start} - {$end}";
    }

    public function responsesCount(): int
    {
        return $this->event->responses()->count();
    }
}
