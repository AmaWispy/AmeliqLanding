@props(['data'])

<section class="guarantees" {{ $attributes }}>
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ $data['title'] ?? 'Гарантии' }}</h2>
            <p class="section-subtitle">{{ $data['subtitle'] ?? '' }}</p>
        </div>
        <div class="guarantees-grid">
            @foreach($data['items'] ?? [] as $item)
                <div class="guarantee-box {{ ($item['type'] ?? 'success') === 'warning' ? 'warning' : 'success' }}">
                    <div class="g-icon"><i class="{{ $item['icon_class'] ?? 'fas fa-check' }}"></i></div>
                    <h3>{{ $item['title'] ?? '' }}</h3>
                    <p>{{ $item['description'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

