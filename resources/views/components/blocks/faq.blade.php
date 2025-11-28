@props(['data'])

<section class="faq" {{ $attributes }}>
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ $data['title'] ?? 'Часто задаваемые вопросы' }}</h2>
            <p class="section-subtitle">
                {{ $data['subtitle'] ?? '' }}
            </p>
        </div>
        <div class="faq-list">
            @foreach($data['items'] ?? [] as $item)
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>{{ $item['question'] ?? '' }}</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        {!! $item['answer'] ?? '' !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

