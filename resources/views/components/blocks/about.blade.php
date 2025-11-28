@props(['data'])

<section id="about" class="about" {{ $attributes }}>
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ $data['title'] ?? 'О нас' }}</h2>
            <p class="section-subtitle">
                {{ $data['subtitle'] ?? '' }}
            </p>
        </div>
        
        <div class="about-manifesto">
            <div class="manifesto-content">
                {!! $data['manifesto_text'] ?? '' !!}
            </div>
            <div class="manifesto-visual">
                <div class="founder-badge">
                    <div class="badge-icon">
                        <i class="fas fa-code-branch"></i>
                    </div>
                    <div class="badge-text">
                        <span>Основано разработчиком</span>
                        <small>Контроль качества кода лично</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="about-principles-grid">
            @foreach($data['principles'] ?? [] as $item)
                <div class="principle-card">
                    <div class="principle-icon">
                        <i class="{{ $item['icon_class'] ?? 'fas fa-check' }}"></i>
                    </div>
                    <h4>{{ $item['title'] ?? '' }}</h4>
                    <p>{{ $item['description'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

