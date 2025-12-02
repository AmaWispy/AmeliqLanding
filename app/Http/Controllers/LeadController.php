<?php

namespace App\Http\Controllers;

use App\Mail\LeadReceived;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    public function submit(Request $request)
    {
        $data = $request->all();
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
            try {
                $chatIds = explode(',', $settings->telegram_chat_id);
                foreach ($chatIds as $chatId) {
                    $this->sendToTelegram($settings->telegram_bot_token, trim($chatId), $data);
                }
            } catch (\Exception $e) {
                Log::error('Failed to send lead to telegram: ' . $e->getMessage());
            }
        }

        return response()->json(['success' => true, 'message' => 'Заявка успешно отправлена!']);
    }

    private function sendToTelegram($token, $chatId, $data)
    {
        $text = "🔥 <b>Новая заявка с сайта!</b>\n\n";
        
        foreach ($data as $key => $value) {
            if ($key === '_token') continue;
            if (empty($value)) continue;
            
            $keyName = ucfirst($key);
            // Простой перевод популярных полей
            $keyName = match($key) {
                'name' => 'Имя',
                'phone' => 'Телефон',
                'email' => 'Email',
                'source' => 'Источник',
                'message' => 'Сообщение',
                default => $keyName
            };
            
            $text .= "<b>{$keyName}:</b> " . strip_tags($value) . "\n";
        }

        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        
        Http::post($url, [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ]);
    }
}

