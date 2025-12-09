<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ ($page->slug === 'home' && !empty($settings->site_description)) ? $settings->site_description : ($page->description ?? '') }}">
    <title>
        @if($page->slug === 'home' && !empty($settings->site_title))
            {{ $settings->site_title }}
        @else
            {{ $page->title ?? 'Ameliq' }}
        @endif
    </title>
    
    <!-- Favicon -->
    @if(!empty($settings->favicon))
        <link rel="icon" type="image/x-icon" href="{{ \Illuminate\Support\Facades\Storage::url($settings->favicon) }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ \Illuminate\Support\Facades\Storage::url($settings->favicon) }}">
    @endif
    
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

    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "{{ $settings->site_name ?? 'Ameliq' }}",
        "url": "{{ url('/') }}",
        "logo": "{{ !empty($settings->logo) ? \Illuminate\Support\Facades\Storage::url($settings->logo) : asset('img/logo.png') }}",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "{{ $settings->phone ?? '' }}",
            "contactType": "customer service",
            "email": "{{ $settings->email ?? '' }}"
        },
        "sameAs": [
            "{{ $settings->telegram_url ?? '' }}",
            "{{ $settings->vk_url ?? '' }}",
            "{{ $settings->youtube_url ?? '' }}"
        ]
    }
    </script>
    
    <!-- Analytics & Custom Head Scripts -->
    @if(!empty($settings->google_analytics))
        {!! $settings->google_analytics !!}
    @endif

    @if(!empty($settings->yandex_metrika))
        {!! $settings->yandex_metrika !!}
    @endif

    @if(!empty($settings->google_tag_manager))
        {!! $settings->google_tag_manager !!}
    @endif

    @if(!empty($settings->facebook_pixel))
        {!! $settings->facebook_pixel !!}
    @endif

    @if(!empty($settings->head_scripts))
        {!! $settings->head_scripts !!}
    @endif
</head>
<body>
    <!-- Bot Trap -->
    <form action="{{ route('bot.trap') }}" method="POST" style="position: absolute; opacity: 0; z-index: -1; left: -9999px; height: 0; width: 0; overflow: hidden;">
        @csrf
        <input type="text" name="name" autocomplete="off" tabindex="-1" placeholder="Name">
        <input type="email" name="email" autocomplete="off" tabindex="-1" placeholder="Email">
        <button type="submit">Submit</button>
    </form>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    @if(!empty($settings->logo))
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($settings->logo) }}" alt="{{ $settings->site_name ?? 'Ameliq' }}" style="max-height: 70px;">
                    @else
                        <h2>{{ $settings->site_name ?? 'Ameliq' }}</h2>
                    @endif
                </div>
                <div class="header-contacts">
                    @if(!empty($settings->phone))
                        <x-safe-link 
                            :href="'tel:' . preg_replace('/[^0-9+]/', '', $settings->phone)" 
                            :text="$settings->phone" 
                            icon="fas fa-phone" 
                            class="header-contact-item"
                        />
                    @endif
                    
                    @if(!empty($settings->telegram_url))
                        <x-safe-link 
                            :href="$settings->telegram_url" 
                            :text="'@' . basename($settings->telegram_url)" 
                            icon="fab fa-telegram" 
                            class="header-contact-item"
                        />
                    @endif

                    @if(!empty($settings->email))
                        <x-safe-link 
                            :href="'mailto:' . $settings->email" 
                            :text="$settings->email" 
                            icon="fas fa-envelope" 
                            class="header-contact-item"
                        />
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @if($page->content)
            @foreach($page->content as $block)
                @if(!isset($block['data']['is_visible']) || $block['data']['is_visible'])
                    <x-dynamic-component :component="'blocks.' . $block['type']" :data="$block['data']" />
                @endif
            @endforeach
        @endif
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-bottom" style="border: none; padding: 2rem 0; display: flex; flex-direction: column; align-items: center; gap: 1rem;">
                <a href="#" class="privacy-link" id="openPrivacyPolicy" style="color: #b0b0b0; font-size: 0.9rem; text-decoration: none; border-bottom: 1px dashed #b0b0b0; transition: color 0.3s;">Политика конфиденциальности</a>
                <p>&copy; {{ date('Y') }} Ameliq. Все права защищены.</p>
            </div>
        </div>
    </footer>

    <!-- Modals & Scripts -->
    <!-- Universal Request Modal -->
    <div id="requestModal" class="exit-popup">
        <div class="popup-content">
            <button class="popup-close request-close">&times;</button>
            <h3>{{ $settings->popup_request_title ?? 'Обсудить проект' }}</h3>
            <p>{{ $settings->popup_request_subtitle ?? 'Оставьте контакты, и мы свяжемся с вами в течение 15 минут' }}</p>
            <form class="popup-form" id="universalForm" style="flex-direction: column;" action="{{ route('lead.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="source" id="formSource" value="General">
                <input type="text" name="name" placeholder="Ваше имя" required style="width: 100%;">
                <input type="tel" name="phone" placeholder="Ваш телефон" required style="width: 100%;">
                <button type="submit" class="btn btn-primary btn-full">{{ $settings->popup_request_button_text ?? 'Жду звонка' }}</button>
                <p class="form-note" style="margin-top: 10px; font-size: 0.8rem;">Нажимая кнопку, вы соглашаетесь с политикой обработки данных</p>
            </form>
        </div>
    </div>

    <!-- Exit Intent Popup -->
    <div id="exitPopup" class="exit-popup">
        <div class="popup-content">
            <button class="popup-close">&times;</button>
            <h3>{{ $settings->popup_exit_title ?? 'Уже уходите?' }}</h3>
            <p>{{ $settings->popup_exit_subtitle ?? 'Получите чек-лист "10 шагов к продающему лендингу" бесплатно!' }}</p>
            <form class="popup-form" action="{{ route('lead.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="source" value="Exit Intent">
                <input type="email" name="email" placeholder="Ваш email" required>
                <button type="submit" class="btn btn-primary">{{ $settings->popup_exit_button_text ?? 'Получить подарок' }}</button>
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

    <!-- Cookie Banner -->
    <div id="cookieBanner" class="cookie-banner">
        <div class="container">
            <div class="cookie-content">
                <p>Мы используем cookie для улучшения работы сайта. Продолжая просмотр, вы соглашаетесь с нашей <a href="#" id="openPrivacyPolicy" class="privacy-link">политикой конфиденциальности</a>.</p>
                <button id="acceptCookie" class="btn btn-primary btn-small">Хорошо</button>
            </div>
        </div>
    </div>

    <!-- Privacy Policy Modal -->
    <div id="privacyModal" class="case-modal" style="display: none;">
        <button class="case-modal-close privacy-close">&times;</button>
        <div class="case-modal-container" style="background: #1a1a1a; color: #e0e0e0; padding: 40px; max-width: 900px; width: 90%; max-height: 90vh; overflow-y: auto;">
            <h3 style="margin-bottom: 20px; font-size: 1.8rem;">Политика в отношении обработки персональных данных</h3>
            <div class="privacy-text" style="color: #e0e0e0; line-height: 1.6; font-size: 0.95rem; text-align: left;">
                <p><strong>1. Общие положения</strong><br>
                Настоящая политика обработки персональных данных составлена в соответствии с требованиями Федерального закона от 27.07.2006. № 152-ФЗ «О персональных данных» (далее — Закон о персональных данных) и определяет порядок обработки персональных данных и меры по обеспечению безопасности персональных данных, предпринимаемые Компанией Ameliq (далее — Оператор).</p>
                
                <p>1.1. Оператор ставит своей важнейшей целью и условием осуществления своей деятельности соблюдение прав и свобод человека и гражданина при обработке его персональных данных, в том числе защиты прав на неприкосновенность частной жизни, личную и семейную тайну.</p>
                
                <p>1.2. Настоящая политика Оператора в отношении обработки персональных данных (далее — Политика) применяется ко всей информации, которую Оператор может получить о посетителях веб-сайта https://ameliq.ru.</p>

                <p><strong>2. Основные понятия, используемые в Политике</strong></p>
                <p>2.1. Автоматизированная обработка персональных данных — обработка персональных данных с помощью средств вычислительной техники.</p>
                <p>2.2. Блокирование персональных данных — временное прекращение обработки персональных данных (за исключением случаев, если обработка необходима для уточнения персональных данных).</p>
                <p>2.3. Веб-сайт — совокупность графических и информационных материалов, а также программ для ЭВМ и баз данных, обеспечивающих их доступность в сети интернет по сетевому адресу https://ameliq.ru.</p>
                <p>2.4. Информационная система персональных данных — совокупность содержащихся в базах данных персональных данных и обеспечивающих их обработку информационных технологий и технических средств.</p>
                <p>2.5. Обезличивание персональных данных — действия, в результате которых невозможно определить без использования дополнительной информации принадлежность персональных данных конкретному Пользователю или иному субъекту персональных данных.</p>
                <p>2.6. Обработка персональных данных — любое действие (операция) или совокупность действий (операций), совершаемых с использованием средств автоматизации или без использования таких средств с персональными данными, включая сбор, запись, систематизацию, накопление, хранение, уточнение (обновление, изменение), извлечение, использование, передачу (распространение, предоставление, доступ), обезличивание, блокирование, удаление, уничтожение персональных данных.</p>
                <p>2.7. Оператор — государственный орган, муниципальный орган, юридическое или физическое лицо, самостоятельно или совместно с другими лицами организующие и/или осуществляющие обработку персональных данных, а также определяющие цели обработки персональных данных, состав персональных данных, подлежащих обработке, действия (операции), совершаемые с персональными данными.</p>
                <p>2.8. Персональные данные — любая информация, относящаяся прямо или косвенно к определенному или определяемому Пользователю веб-сайта https://ameliq.ru.</p>
                <p>2.9. Пользователь — любой посетитель веб-сайта https://ameliq.ru.</p>
                <p>2.10. Предоставление персональных данных — действия, направленные на раскрытие персональных данных определенному лицу или определенному кругу лиц.</p>
                <p>2.11. Распространение персональных данных — любые действия, направленные на раскрытие персональных данных неопределенному кругу лиц.</p>
                <p>2.12. Трансграничная передача персональных данных — передача персональных данных на территорию иностранного государства органу власти иностранного государства, иностранному физическому или иностранному юридическому лицу.</p>
                <p>2.13. Уничтожение персональных данных — любые действия, в результате которых персональные данные уничтожаются безвозвратно с невозможностью дальнейшего восстановления содержания персональных данных в информационной системе персональных данных.</p>

                <p><strong>3. Основные права и обязанности Оператора</strong></p>
                <p>3.1. Оператор имеет право:<br>
                — получать от субъекта персональных данных достоверные информацию и/или документы, содержащие персональные данные;<br>
                — в случае отзыва субъектом персональных данных согласия на обработку персональных данных Оператор вправе продолжить обработку персональных данных без согласия субъекта персональных данных при наличии оснований, указанных в Законе о персональных данных;<br>
                — самостоятельно определять состав и перечень мер, необходимых и достаточных для обеспечения выполнения обязанностей, предусмотренных Законом о персональных данных.</p>
                <p>3.2. Оператор обязан:<br>
                — предоставлять субъекту персональных данных по его просьбе информацию, касающуюся обработки его персональных данных;<br>
                — организовывать обработку персональных данных в порядке, установленном действующим законодательством РФ;<br>
                — отвечать на обращения и запросы субъектов персональных данных и их законных представителей;<br>
                — сообщать в уполномоченный орган по защите прав субъектов персональных данных по запросу этого органа необходимую информацию в течение 10 дней с даты получения такого запроса;<br>
                — публиковать или иным образом обеспечивать неограниченный доступ к настоящей Политике;<br>
                — принимать правовые, организационные и технические меры для защиты персональных данных от неправомерного или случайного доступа к ним.</p>

                <p><strong>4. Основные права и обязанности субъектов персональных данных</strong></p>
                <p>4.1. Субъекты персональных данных имеют право:<br>
                — получать информацию, касающуюся обработки его персональных данных;<br>
                — требовать от оператора уточнения его персональных данных, их блокирования или уничтожения в случае, если персональные данные являются неполными, устаревшими, неточными, незаконно полученными или не являются необходимыми для заявленной цели обработки;<br>
                — выдвигать условие предварительного согласия при обработке персональных данных в целях продвижения на рынке товаров, работ и услуг;<br>
                — на отзыв согласия на обработку персональных данных;<br>
                — обжаловать в уполномоченный орган по защите прав субъектов персональных данных или в судебном порядке неправомерные действия или бездействие Оператора.<br>
                4.2. Субъекты персональных данных обязаны:<br>
                — предоставлять Оператору достоверные данные о себе;<br>
                — сообщать Оператору об уточнении (обновлении, изменении) своих персональных данных.</p>

                <p><strong>5. Принципы обработки персональных данных</strong></p>
                <p>5.1. Обработка персональных данных осуществляется на законной и справедливой основе.<br>
                5.2. Обработка персональных данных ограничивается достижением конкретных, заранее определенных и законных целей.<br>
                5.3. Не допускается объединение баз данных, содержащих персональные данные, обработка которых осуществляется в целях, несовместимых между собой.<br>
                5.4. Обработке подлежат только персональные данные, которые отвечают целям их обработки.<br>
                5.5. Содержание и объем обрабатываемых персональных данных соответствуют заявленным целям обработки.<br>
                5.6. При обработке персональных данных обеспечивается точность персональных данных, их достаточность, а в необходимых случаях и актуальность по отношению к целям обработки персональных данных.<br>
                5.7. Хранение персональных данных осуществляется в форме, позволяющей определить субъекта персональных данных, не дольше, чем этого требуют цели обработки персональных данных.</p>

                <p><strong>6. Цели обработки персональных данных</strong></p>
                <p>Цель обработки: Запись на консультацию, обсуждение проекта.<br>
                Персональные данные: номера телефонов, имя.<br>
                Правовые основания: уставные документы Оператора, договоры с субъектом персональных данных.<br>
                Виды обработки персональных данных: Сбор, запись, систематизация, накопление, хранение, уничтожение и обезличивание персональных данных.</p>

                <p><strong>7. Условия обработки персональных данных</strong></p>
                <p>7.1. Обработка персональных данных осуществляется с согласия субъекта персональных данных на обработку его персональных данных.<br>
                7.2. Обработка персональных данных необходима для достижения целей, предусмотренных законом.<br>
                7.3. Обработка персональных данных необходима для исполнения договора, стороной которого является субъект персональных данных.<br>
                7.4. Оператор обеспечивает сохранность персональных данных и принимает все возможные меры, исключающие доступ к персональным данным неуполномоченных лиц.</p>

                <p><strong>8. Актуализация, исправление, удаление и уничтожение персональных данных</strong></p>
                <p>8.1. В случае выявления неточностей в персональных данных, Пользователь может актуализировать их самостоятельно, путем направления Оператору уведомление на адрес электронной почты Оператора info@ameliq.ru с пометкой «Актуализация персональных данных».<br>
                8.2. Срок обработки персональных данных определяется достижением целей, для которых были собраны персональные данные.<br>
                Пользователь может в любой момент отозвать свое согласие на обработку персональных данных, направив Оператору уведомление посредством электронной почты на электронный адрес Оператора info@ameliq.ru с пометкой «Отзыв согласия на обработку персональных данных».</p>

                <p><strong>9. Заключительные положения</strong></p>
                <p>9.1. Пользователь может получить любые разъяснения по интересующим вопросам, касающимся обработки его персональных данных, обратившись к Оператору с помощью электронной почты info@ameliq.ru.<br>
                9.2. В данном документе будут отражены любые изменения политики обработки персональных данных Оператором. Политика действует бессрочно до замены ее новой версией.<br></p>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}?v={{ time() }}"></script>

    <!-- Custom Body Scripts -->
    @if(!empty($settings->body_scripts))
        {!! $settings->body_scripts !!}
    @endif
</body>
</html>
