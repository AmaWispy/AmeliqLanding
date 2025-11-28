@props(['data'])

<section class="testimonials" {{ $attributes }}>
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ $data['title'] ?? 'Отзывы клиентов' }}</h2>
            <p class="section-subtitle">
                {{ $data['subtitle'] ?? '' }}
            </p>
        </div>
    </div>
    
    <div class="marquee-wrapper">
        <div class="marquee-content">
            <!-- Set 1 -->
            @foreach($data['items'] ?? [] as $item)
                <div class="testimonial-card-mini">
                    <div class="user-info">
                        <div class="avatar {{ $item['avatar_color'] ?? 'blue' }}">{{ mb_substr($item['name'] ?? 'U', 0, 1) }}</div>
                        <div>
                            <h4>{{ $item['name'] ?? '' }}</h4>
                            <small>{{ $item['role'] ?? '' }}</small>
                        </div>
                    </div>
                    <p>"{{ $item['text'] ?? '' }}"</p>
                </div>
            @endforeach

             <!-- Duplicate for infinite scroll (simplified logic for now, just repeating the loop) -->
            @foreach($data['items'] ?? [] as $item)
                <div class="testimonial-card-mini">
                    <div class="user-info">
                        <div class="avatar {{ $item['avatar_color'] ?? 'blue' }}">{{ mb_substr($item['name'] ?? 'U', 0, 1) }}</div>
                        <div>
                            <h4>{{ $item['name'] ?? '' }}</h4>
                            <small>{{ $item['role'] ?? '' }}</small>
                        </div>
                    </div>
                    <p>"{{ $item['text'] ?? '' }}"</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

