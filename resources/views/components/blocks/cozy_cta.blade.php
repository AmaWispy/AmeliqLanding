@props(['data'])

<section class="cozy-cta" {{ $attributes }}>
    <div class="container">
        <div class="cozy-cta-content">
            <h2 class="cozy-cta-title">
                {{ $data['title'] ?? 'Просто хотите спросить?' }}
            </h2>
            <p class="cozy-cta-subtitle">
                {{ $data['subtitle'] ?? '' }}
            </p>
            <div class="cozy-cta-btn">
                <a href="{{ $data['button_link'] ?? '#' }}" 
                   class="btn btn-outline btn-large js-open-modal" 
                   data-source="Bottom Contact Section (Cozy CTA)"
                   @if(!empty($data['button_link']) && $data['button_link'] !== '#') target="_blank" @endif
                >
                    <i class="fab fa-telegram"></i>
                    {{ $data['button_text'] ?? 'Написать в Telegram' }}
                </a>
            </div>
        </div>
    </div>
</section>

