    {{-- Дополнительные скрипты перед закрывающим тегом body --}}
    @if(settings('body_scripts'))
        {!! settings('body_scripts') !!}
    @endif

    {{-- Стек для дополнительных скриптов --}}
    @stack('scripts')

</body>
</html>

