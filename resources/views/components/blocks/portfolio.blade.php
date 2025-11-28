@props(['data'])

<section id="portfolio" class="portfolio" {{ $attributes }}>
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ $data['title'] ?? 'Наши кейсы' }}</h2>
            <p class="section-subtitle">
                {{ $data['subtitle'] ?? '' }}
            </p>
        </div>
        <div class="portfolio-grid">
            @foreach($data['items'] ?? [] as $item)
                <div class="portfolio-item" data-case-url="{{ $item['url'] ?? '#' }}">
                    <div class="portfolio-image">
                        @if(!empty($item['image']))
                            {{-- 
                                Check if image is a full URL or local path.
                                If it starts with http or has no extension (often stored by Filament without disk prefix), handle accordingly.
                                Here we support both direct public paths (from seeder) and storage paths (from Filament uploads).
                            --}}
                            @php
                                $imageUrl = $item['image'];
                                if (!str_starts_with($imageUrl, 'http')) {
                                    if (file_exists(public_path($imageUrl))) {
                                        $imageUrl = asset($imageUrl);
                                    } else {
                                        $imageUrl = \Illuminate\Support\Facades\Storage::url($imageUrl);
                                    }
                                }
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $item['title'] ?? '' }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; background: #222; display: flex; align-items: center; justify-content: center;">NO IMAGE</div>
                        @endif
                        <div class="portfolio-overlay">
                            <h4>{{ $item['title'] ?? '' }}</h4>
                            <p>{{ $item['description'] ?? '' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <div class="portfolio-item audience-card highlight-card" style="height: 300px; display: flex; flex-direction: column; justify-content: center;">
                <div class="audience-icon">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <h3>Ваш проект</h3>
                <p>Следующий кейс может быть вашим. Мы готовы реализовать любую вашу идею.</p>
            </div>
        </div>
        <div class="section-cta">
            <a href="#" class="btn btn-primary btn-large js-open-modal" data-source="Portfolio Section">
                Хочу также!
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
