<?php

use App\Models\Setting;

if (!function_exists('settings')) {
    /**
     * Получить настройки сайта
     *
     * @param string|null $key Ключ настройки (например, 'site_title')
     * @param mixed $default Значение по умолчанию
     * @return mixed
     */
    function settings(?string $key = null, mixed $default = null): mixed
    {
        $settings = cache()->remember('site_settings', 3600, function () {
            return Setting::first();
        });

        if (is_null($key)) {
            return $settings;
        }

        return $settings?->$key ?? $default;
    }
}

if (!function_exists('setting')) {
    /**
     * Алиас для функции settings()
     */
    function setting(?string $key = null, mixed $default = null): mixed
    {
        return settings($key, $default);
    }
}

