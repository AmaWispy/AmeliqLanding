<?php

namespace App\Http\Controllers;

use App\Mail\LeadReceived;
use App\Models\Lead;
use App\Models\Setting;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function submit(Request $request)
    {
        $data = $request->all();
        
        // Сохранение в БД
        try {
            Lead::create([
                'name' => $data['name'] ?? null,
                'phone' => $data['phone'] ?? null,
                'email' => $data['email'] ?? null,
                'source' => $data['source'] ?? null,
                'message' => $data['message'] ?? null,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'payload' => $data,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to save lead to database: ' . $e->getMessage());
            // Не прерываем выполнение, чтобы отправить уведомления
        }

        $settings = Setting::getSiteSettings();

        // 1. Отправка на Email
        if (!empty($settings->lead_email)) {
            try {
                Mail::to($settings->lead_email)->send(new LeadReceived($data));
            } catch (\Exception $e) {
                Log::error('Failed to send lead email: ' . $e->getMessage());
            }
        }

        // 2. Отправка в Telegram
        if (!empty($settings->telegram_bot_token) && !empty($settings->telegram_chat_id)) {
            $this->telegramService->sendLead(
                $settings->telegram_bot_token, 
                $settings->telegram_chat_id, 
                $data
            );
        }

        return response()->json(['success' => true, 'message' => 'Заявка успешно отправлена!']);
    }
}

