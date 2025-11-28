@props(['data'])

<section id="advantages" class="advantages" {{ $attributes }}>
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ $data['title'] ?? 'Наши преимущества' }}</h2>
            <p class="section-subtitle">
                {{ $data['subtitle'] ?? '' }}
            </p>
        </div>
        <div class="advantages-grid">
            @foreach($data['items'] ?? [] as $item)
                <div class="advantage-card">
                    <div class="advantage-icon">
                        <i class="{{ $item['icon_class'] ?? 'fas fa-star' }}"></i>
                    </div>
                    <h3 class="advantage-title">{{ $item['title'] ?? '' }}</h3>
                    <p class="advantage-description">
                        {{ $item['description'] ?? '' }}
                    </p>
                </div>
            @endforeach
        </div>
        <div class="section-cta">
            <a href="#" class="btn btn-primary btn-large js-open-modal" data-source="Advantages Section">
                Обсудить, как мы можем обойти ваших конкурентов
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

