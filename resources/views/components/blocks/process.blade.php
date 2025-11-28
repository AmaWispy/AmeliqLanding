@props(['data'])

<section id="process" class="process" {{ $attributes }}>
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ $data['title'] ?? 'Процесс работы' }}</h2>
            <p class="section-subtitle">
                {{ $data['subtitle'] ?? '' }}
            </p>
        </div>
        <div class="process-timeline">
            @foreach($data['steps'] ?? [] as $step)
                <div class="process-step">
                    <div class="step-number">{{ $step['step_number'] ?? $loop->iteration }}</div>
                    <div class="step-icon"><i class="{{ $step['icon_class'] ?? 'fas fa-circle' }}"></i></div>
                    <h3 class="step-title">{{ $step['title'] ?? '' }}</h3>
                    <p class="step-description">{{ $step['description'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
        <div class="process-cta">
            <a href="#" class="btn btn-primary btn-large js-open-modal" data-source="Process Section - Let's Work">
                Давайте работать
                <i class="fas fa-handshake"></i>
            </a>
        </div>
    </div>
</section>

