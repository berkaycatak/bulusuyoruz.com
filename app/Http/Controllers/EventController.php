<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use App\Services\EventService;
use App\ViewModels\EventViewModel;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(
        protected EventService $eventService
    ) {}

    public function create()
    {
        return view('events.create');
    }

    public function store(StoreEventRequest $request)
    {
        try {
            $event = $this->eventService->createEvent($request->user(), $request->validated());
            return redirect()->route('events.show', $event->slug)->with('success', 'Etkinlik başarıyla oluşturuldu!');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Illuminate\Support\Facades\Log::error('Event creation failed: ' . $e->getMessage());

            $message = config('app.debug') 
                ? 'Sistem hatası: ' . $e->getMessage() 
                : 'Beklenmedik bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz.';
            
            return view('events.error')->with('error', $message);
        }
    }

    public function show(Event $event)
    {
        // Load relationships (responses) if needed for the view
        $event->load(['responses', 'user']);
        
        $viewModel = new EventViewModel($event, auth()->user());

        return view('events.show', compact('viewModel'));
    }
}
