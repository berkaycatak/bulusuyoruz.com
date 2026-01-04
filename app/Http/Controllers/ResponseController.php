<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResponseRequest;
use App\Models\Event;
use App\Models\Response;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function __construct(
        protected ResponseService $responseService
    ) {}

    public function store(StoreResponseRequest $request, Event $event)
    {
        try {
            $this->responseService->createResponse(
                $event,
                $request->user(),
                $request->validated(),
                $request->ip()
            );

            return redirect()->route('events.result', $event->slug)->with('success', 'Yanıtınız kaydedildi!');
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Response creation failed: ' . $e->getMessage());

             $message = config('app.debug') 
                ? 'Sistem hatası: ' . $e->getMessage() 
                : 'Beklenmedik bir sorun oluştu. Lütfen tekrar deneyiniz.';

            return back()->with('error', $message);
        }
    }

    /**
     * Delete a response (soft delete).
     * Only the event owner can delete responses.
     */
    public function destroy(Request $request, Event $event, Response $response)
    {
        // Authorization: Only event owner can delete responses
        if ($event->user_id !== $request->user()?->id) {
            abort(403, 'Bu işlemi gerçekleştirme yetkiniz yok.');
        }

        // Make sure the response belongs to the event
        if ($response->event_id !== $event->id) {
            abort(404, 'Yanıt bulunamadı.');
        }

        $response->delete();

        return back()->with('success', 'Yanıt başarıyla silindi.');
    }
}

