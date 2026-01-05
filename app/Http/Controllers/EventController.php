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
        // Load event relationships (excluding responses to avoid loading all of them)
        $event->load(['user']);
        
        // Paginate responses separately
        $responses = $event->responses()
            ->with(['province', 'district', 'user'])
            ->latest()
            ->paginate(10);
        
        $viewModel = new EventViewModel($event, auth()->user());

        return view('events.show', compact('viewModel', 'responses'));
    }

    public function edit(Event $event)
    {
        // Authorization check: Ensure only the creator can edit
        if (auth()->id() !== $event->user_id) {
            abort(403, 'Bu etkinliği düzenleme yetkiniz yok.');
        }

        return view('events.edit', compact('event'));
    }

    public function update(\App\Http\Requests\UpdateEventRequest $request, Event $event)
    {
        // ... existing update code ...
        try {
            $this->eventService->updateEvent($event, $request->validated());
            return redirect()->route('events.show', $event->slug)->with('success', 'Etkinlik başarıyla güncellendi!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Event update failed: ' . $e->getMessage());
            return back()->with('error', 'Güncelleme sırasında bir hata oluştu.');
        }
    }

    public function finalize(Event $event, \App\Services\Ai\AiServiceInterface $aiService)
    {
        if (auth()->id() !== $event->user_id) {
            abort(403);
        }

        // Removed the check that prevents re-running analysis
        // if ($event->status === 'completed') { ... }

        try {
            $analysis = $aiService->analyzeEvent($event);

            // Use updateOrCreate to either create a new result or update the existing one
            $event->result()->updateOrCreate(
                ['event_id' => $event->id], // Condition to find existing
                [
                    'suggested_location' => $analysis['suggested_location'],
                    'suggested_date' => $analysis['suggested_date'],
                    'suggested_time' => $analysis['suggested_time'],
                    'reasoning' => $analysis['reasoning'],
                ]
            );

            $event->update(['status' => 'completed']);

            return redirect()->route('events.show', $event->slug)->with('success', 'Yapay zeka planlamayı güncelledi! 🚀');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('AI Finalize Error: ' . $e->getMessage());
            return back()->with('error', 'Yapay zeka servisi şu an yanıt veremiyor. Lütfen daha sonra tekrar deneyin.');
        }
    }

    /**
     * Reactivate a completed event to continue receiving responses.
     */
    public function reactivate(Event $event)
    {
        if (auth()->id() !== $event->user_id) {
            abort(403);
        }

        if ($event->status !== 'completed') {
            return back()->with('info', 'Bu etkinlik zaten aktif durumda.');
        }

        // Set status back to active (or 'pending' depending on your schema)
        $event->update(['status' => 'active']);

        return redirect()->route('events.show', $event->slug)->with('success', 'Etkinlik tekrar aktif edildi! Artık yeni yanıtlar alabilirsin. ✅');
    }
}
