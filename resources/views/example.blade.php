@extends('layout.app')

@push('styles')
<style>
    .custom-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 1rem;
    }
</style>
@endpush

@push('head-scripts')
<script>
    console.log('Этот скрипт загружается в head');
</script>
@endpush

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 py-16">
        <div class="container mx-auto px-4">
            <div class="custom-header text-center mb-8">
                <h1 class="text-4xl font-bold">
                    Пример использования layout
                </h1>
                <p class="mt-4 text-lg">
                    Эта страница показывает как использовать layout с кастомными стилями
                </p>
            </div>
            
            <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-xl p-8">
                <h2 class="text-2xl font-semibold mb-4">Что включено в header.blade.php:</h2>
                
                <ul class="space-y-3 text-gray-700">
                    <li>✅ Мета-теги (title, description, keywords) из настроек</li>
                    <li>✅ Фавикон из настроек</li>
                    <li>✅ Open Graph теги для социальных сетей</li>
                    <li>✅ Twitter Card теги</li>
                    <li>✅ Google Analytics код</li>
                    <li>✅ Яндекс Метрика код</li>
                    <li>✅ Google Tag Manager</li>
                    <li>✅ Facebook Pixel</li>
                    <li>✅ Дополнительные скрипты в head</li>
                    <li>✅ Стеки для кастомных стилей (@push('styles'))</li>
                    <li>✅ Стеки для кастомных скриптов (@push('head-scripts'))</li>
                </ul>
                
                <h2 class="text-2xl font-semibold mt-8 mb-4">Что включено в footer.blade.php:</h2>
                
                <ul class="space-y-3 text-gray-700">
                    <li>✅ Дополнительные скрипты перед &lt;/body&gt;</li>
                    <li>✅ Стек для кастомных скриптов (@push('scripts'))</li>
                    <li>✅ Закрывающие теги &lt;/body&gt; и &lt;/html&gt;</li>
                </ul>
                
                <div class="mt-8 p-6 bg-blue-50 rounded-lg">
                    <h3 class="text-xl font-semibold mb-2">Как использовать:</h3>
                    <pre class="bg-gray-800 text-white p-4 rounded mt-2 overflow-x-auto"><code>@verbatim@extends('layout.app')

@push('styles')
<style>
    /* Ваши стили */
</style>
@endpush

@section('content')
    <!-- Ваш контент -->
@endsection

@push('scripts')
<script>
    // Ваши скрипты
</script>
@endpush@endverbatim</code></pre>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    console.log('Этот скрипт загружается перед закрывающим тегом body');
</script>
@endpush

