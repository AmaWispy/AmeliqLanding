@extends('layout.app')

@section('content')
    <div class="min-h-screen bg-gray-100">
        <div class="container mx-auto px-4 py-16">
            <h1 class="text-4xl font-bold text-center mb-8">
                {{ settings('site_name') ?? 'Добро пожаловать!' }}
            </h1>
            
            <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
                <p class="text-lg text-gray-700 mb-4">
                    {{ settings('site_description') }}
                </p>
                
                <div class="mt-8">
                    <h2 class="text-2xl font-semibold mb-4">Контакты:</h2>
                    
                    @if(settings('email'))
                        <p class="mb-2">
                            <strong>Email:</strong> 
                            <a href="mailto:{{ settings('email') }}" class="text-blue-600 hover:underline">
                                {{ settings('email') }}
                            </a>
                        </p>
                    @endif
                    
                    @if(settings('phone'))
                        <p class="mb-2">
                            <strong>Телефон:</strong> 
                            <a href="tel:{{ settings('phone') }}" class="text-blue-600 hover:underline">
                                {{ settings('phone') }}
                            </a>
                        </p>
                    @endif
                    
                    @if(settings('address'))
                        <p class="mb-2">
                            <strong>Адрес:</strong> {{ settings('address') }}
                        </p>
                    @endif
                </div>
                
                <div class="mt-8">
                    <h2 class="text-2xl font-semibold mb-4">Мы в социальных сетях:</h2>
                    
                    <div class="flex gap-4">
                        @if(settings('telegram_url'))
                            <a href="{{ settings('telegram_url') }}" target="_blank" rel="noopener" 
                               class="text-blue-500 hover:text-blue-700 transition">
                                Telegram
                            </a>
                        @endif
                        
                        @if(settings('vk_url'))
                            <a href="{{ settings('vk_url') }}" target="_blank" rel="noopener" 
                               class="text-blue-600 hover:text-blue-800 transition">
                                ВКонтакте
                            </a>
                        @endif
                        
                        @if(settings('whatsapp_url'))
                            <a href="{{ settings('whatsapp_url') }}" target="_blank" rel="noopener" 
                               class="text-green-500 hover:text-green-700 transition">
                                WhatsApp
                            </a>
                        @endif
                        
                        @if(settings('youtube_url'))
                            <a href="{{ settings('youtube_url') }}" target="_blank" rel="noopener" 
                               class="text-red-600 hover:text-red-800 transition">
                                YouTube
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

