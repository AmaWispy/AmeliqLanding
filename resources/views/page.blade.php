<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $page->description ?? 'Разработка продающих лендингов под ключ на Laravel.' }}">
    <title>{{ $page->title ?? 'Ameliq' }}</title>
    
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Styles from site-res -->
    <style>
        /* Здесь можно подключить styles.css, если он будет перенесен в public или resources */
        /* Для простоты пока вставим содержимое styles.css или подключим как asset, если вы его положите в public/css */
    </style>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h2>Ameliq</h2>
                </div>
                <div class="header-contacts">
                    <a href="tel:+79991234567" class="header-contact-item">
                        <i class="fas fa-phone"></i>
                        <span>+7 (999) 123-45-67</span>
                    </a>
                    <a href="https://t.me/ameliq_dev" target="_blank" class="header-contact-item">
                        <i class="fab fa-telegram"></i>
                        <span>@ameliq_dev</span>
                    </a>
                    <a href="mailto:info@ameliq.ru" class="header-contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>info@ameliq.ru</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @if($page->content)
            @foreach($page->content as $block)
                <x-dynamic-component :component="'blocks.' . $block['type']" :data="$block['data']" />
            @endforeach
        @endif
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-bottom" style="border: none; padding: 2rem 0;">
                <p>&copy; {{ date('Y') }} Ameliq. Все права защищены.</p>
            </div>
        </div>
    </footer>

    <!-- Modals & Scripts -->
    <!-- Universal Request Modal -->
    <div id="requestModal" class="exit-popup">
        <div class="popup-content">
            <button class="popup-close request-close">&times;</button>
            <h3>Обсудить проект</h3>
            <p>Оставьте контакты, и мы свяжемся с вами в течение 15 минут</p>
            <form class="popup-form" id="universalForm" style="flex-direction: column;">
                <input type="hidden" name="source" id="formSource" value="General">
                <input type="text" name="name" placeholder="Ваше имя" required style="width: 100%;">
                <input type="tel" name="phone" placeholder="Ваш телефон" required style="width: 100%;">
                <button type="submit" class="btn btn-primary btn-full">Жду звонка</button>
                <p class="form-note" style="margin-top: 10px; font-size: 0.8rem;">Нажимая кнопку, вы соглашаетесь с политикой обработки данных</p>
            </form>
        </div>
    </div>

    <!-- Exit Intent Popup -->
    <div id="exitPopup" class="exit-popup">
        <div class="popup-content">
            <button class="popup-close">&times;</button>
            <h3>Уже уходите?</h3>
            <p>Получите чек-лист "10 шагов к продающему лендингу" бесплатно!</p>
            <form class="popup-form">
                <input type="email" placeholder="Ваш email" required>
                <button type="submit" class="btn btn-primary">Получить подарок</button>
            </form>
        </div>
    </div>

    <!-- Case Modal -->
    <div id="caseModal" class="case-modal">
        <button class="case-modal-close">&times;</button>
        <div class="case-modal-container">
            <iframe id="caseFrame" src="" frameborder="0"></iframe>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
