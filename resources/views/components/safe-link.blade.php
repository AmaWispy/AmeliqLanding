@props(['href', 'text', 'icon' => null, 'class' => ''])

@php
    $encodedHref = base64_encode($href);
    $encodedText = base64_encode($text);
@endphp

<a href="#" 
   data-safe-href="{{ $encodedHref }}" 
   class="{{ $class }}"
   onclick="this.href=decodeURIComponent(escape(window.atob(this.dataset.safeHref))); return true;"
   onmouseenter="this.href=decodeURIComponent(escape(window.atob(this.dataset.safeHref)));"
>
    @if($icon)
        <i class="{{ $icon }}"></i>
    @endif
    <span data-safe-text="{{ $encodedText }}">
        Загрузка...
    </span>
</a>

