<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Основные мета-теги из настроек --}}
    <title>{{ settings('site_title') ?? config('app.name') }}</title>
    <meta name="description" content="{{ settings('site_description') }}">
    <meta name="keywords" content="{{ settings('site_keywords') }}">

    {{-- Фавикон --}}
    @if(settings('favicon'))
        <link rel="icon" type="image/x-icon" href="{{ Storage::url(settings('favicon')) }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ Storage::url(settings('favicon')) }}">
    @endif

    {{-- Open Graph мета-теги --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ settings('site_title') ?? config('app.name') }}">
    <meta property="og:description" content="{{ settings('site_description') }}">
    <meta property="og:site_name" content="{{ settings('site_name') ?? config('app.name') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    @if(settings('og_image'))
        <meta property="og:image" content="{{ Storage::url(settings('og_image')) }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
    @endif

    {{-- Twitter Card мета-теги --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ settings('site_title') ?? config('app.name') }}">
    <meta name="twitter:description" content="{{ settings('site_description') }}">
    @if(settings('og_image'))
        <meta name="twitter:image" content="{{ Storage::url(settings('og_image')) }}">
    @endif

    {{-- CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Дополнительные стили --}}
    @stack('styles')

    {{-- Google Tag Manager (head) --}}
    @if(settings('google_tag_manager'))
        {!! settings('google_tag_manager') !!}
    @endif

    {{-- Google Analytics --}}
    @if(settings('google_analytics'))
        {!! settings('google_analytics') !!}
    @endif

    {{-- Яндекс Метрика --}}
    @if(settings('yandex_metrika'))
        {!! settings('yandex_metrika') !!}
    @endif

    {{-- Facebook Pixel --}}
    @if(settings('facebook_pixel'))
        {!! settings('facebook_pixel') !!}
    @endif

    {{-- Дополнительные скрипты в head --}}
    @if(settings('head_scripts'))
        {!! settings('head_scripts') !!}
    @endif

    {{-- Дополнительные скрипты из стека --}}
    @stack('head-scripts')
</head>
<body class="antialiased">
    {{-- Google Tag Manager (body) - если нужно --}}
    @if(settings('google_tag_manager') && str_contains(settings('google_tag_manager'), 'GTM-'))
        @php
            preg_match('/GTM-[A-Z0-9]+/', settings('google_tag_manager'), $matches);
            $gtmId = $matches[0] ?? null;
        @endphp
        @if($gtmId)
            <noscript>
                <iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}"
                    height="0" width="0" style="display:none;visibility:hidden"></iframe>
            </noscript>
        @endif
    @endif

