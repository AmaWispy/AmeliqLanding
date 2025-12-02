<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_title',
        'site_description',
        'site_keywords',
        'favicon',
        'logo',
        'og_image',
        'email',
        'phone',
        'address',
        'telegram_url',
        'vk_url',
        'whatsapp_url',
        'youtube_url',
        'google_analytics',
        'yandex_metrika',
        'google_tag_manager',
        'facebook_pixel',
        'head_scripts',
        'body_scripts',
        'robots_txt',
        'popup_request_title',
        'popup_request_subtitle',
        'popup_request_button_text',
        'popup_exit_title',
        'popup_exit_subtitle',
        'popup_exit_button_text',
        'popup_exit_link',
        'lead_email',
        'telegram_bot_token',
        'telegram_chat_id',
    ];

    /**
     * Получить настройки сайта (первую запись)
     */
    public static function getSiteSettings()
    {
        return self::first() ?? new self();
    }
}
