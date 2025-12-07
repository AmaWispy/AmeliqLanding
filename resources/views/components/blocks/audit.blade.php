@props(['data'])

<section id="audit" class="audit-section" {{ $attributes }}>
    <div class="container">
        <div class="audit-content">
            <div class="audit-info">
                <h2 class="section-title">{{ $data['title'] ?? 'Ваш сайт может продавать больше?' }}</h2>
                <p class="audit-subtitle">
                    {{ $data['subtitle'] ?? '' }}
                </p>
                <div class="audit-features">
                    @foreach($data['features'] ?? [] as $item)
                        <div class="audit-feature">
                            <i class="{{ $item['icon_class'] ?? 'fas fa-check' }}"></i>
                            <span>{{ $item['text'] ?? '' }}</span>
                        </div>
                    @endforeach
                </div>
                <p class="audit-trust">
                    <i class="fas fa-file-alt"></i> Вы получите подробный отчет с рекомендациями, который мы детально разберем на личном созвоне
                </p>
            </div>
            <div class="audit-form-container">
                <form class="audit-form" id="auditForm">
                    @csrf
                    <input type="hidden" name="source" value="Audit Form Section">
                    <h3>Получить бесплатный аудит</h3>
                    <div class="form-group">
                        <input type="text" id="audit-name" name="name" placeholder="Ваше имя" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" id="audit-phone" name="phone" placeholder="Телефон" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">
                        Получить аудит бесплатно
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

