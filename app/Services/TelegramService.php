<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    /**
     * Отправляет данные заявки в один или несколько чатов Telegram.
     *
     * @param string $token Токен бота
     * @param string $chatIds Строка с ID чатов через запятую
     * @param array $data Данные формы
     * @return void
     */
    public function sendLead(string $token, string $chatIds, array $data): void
    {
        $text = $this->formatMessage($data);
        $chatIdArray = explode(',', $chatIds);

        foreach ($chatIdArray as $chatId) {
            $this->sendMessage($token, trim($chatId), $text);
        }
    }

    /**
     * Отправляет сообщение в конкретный чат.
     */
    protected function sendMessage(string $token, string $chatId, string $text): void
    {
        if (empty($chatId)) {
            return;
        }

        try {
            $url = "https://api.telegram.org/bot{$token}/sendMessage";
            
            $response = Http::withoutVerifying()->post($url, [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML',
            ]);

            if (!$response->successful()) {
                Log::error("Telegram API Error for chat {$chatId}: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error("Failed to send Telegram message to {$chatId}: " . $e->getMessage());
        }
    }

    /**
     * Форматирует данные заявки в текст сообщения.
     */
    protected function formatMessage(array $data): string
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
                'page_title' => 'Страница',
                default => $keyName
            };
            
            $text .= "<b>{$keyName}:</b> " . strip_tags((string)$value) . "\n";
        }

        return $text;
    }
}

