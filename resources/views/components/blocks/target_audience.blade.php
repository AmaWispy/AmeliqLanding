@props(['data'])

<section class="target-audience" {{ $attributes }}>
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ $data['title'] ?? 'Кому подойдет' }}</h2>
            <p class="section-subtitle">
                {{ $data['subtitle'] ?? '' }}
            </p>
        </div>
        <div class="audience-grid">
            @foreach($data['items'] ?? [] as $item)
                <div class="audience-card {{ !empty($item['is_highlight']) ? 'highlight-card' : '' }}">
                    <div class="audience-icon">
                        <i class="{{ $item['icon_class'] ?? 'fas fa-user' }}"></i>
                    </div>
                    <h3>{{ $item['title'] ?? '' }}</h3>
                    <p>{{ $item['description'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
        <div class="section-cta">
            <a href="#" class="btn btn-primary btn-large js-open-modal" data-source="Target Audience Section">
                Обсудить мой проект
                <i class="fab fa-telegram-plane"></i>
            </a>
        </div>
    </div>
</section>

