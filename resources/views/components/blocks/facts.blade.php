@props(['data'])

<section class="facts" {{ $attributes }}>
    <div class="container">
        <div class="facts-grid">
            @foreach($data['items'] ?? [] as $item)
                <div class="fact-item">
                    <div class="fact-icon">
                        <i class="{{ $item['icon_class'] ?? 'fas fa-star' }}"></i>
                    </div>
                    <div class="fact-number">{{ $item['number'] ?? '' }}</div>
                    <div class="fact-label">{{ $item['label'] ?? '' }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

