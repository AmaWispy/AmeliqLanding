@props(['data'])

<section id="home" class="hero" {{ $attributes }}>
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">
                    {!! $data['title'] ?? 'Создаем лендинги, приносящие <span class="highlight">теплые заявки</span>' !!}
                </h1>
                <p class="hero-subtitle">
                    {{ $data['subtitle'] ?? '' }}
                </p>
                <div class="hero-cta">
                    <a href="{{ $data['button_link'] ?? '#' }}" class="btn btn-primary btn-large js-open-modal" data-source="Hero Main Button">
                        {{ $data['button_text'] ?? 'Узнать какой лендинг подойдет вам' }}
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="devices-mockup">
                    <!-- Desktop -->
                    <div class="device device-desktop">
                        <div class="device-frame">
                            <div class="browser-header">
                                <div class="browser-dots">
                                    <span class="dot red"></span>
                                    <span class="dot yellow"></span>
                                    <span class="dot green"></span>
                                </div>
                            </div>
                            <div class="device-screen">
                                <div class="screen-content">
                                    <div class="mini-header"></div>
                                    <div class="mini-hero">
                                        <div class="mini-title"></div>
                                        <div class="mini-subtitle"></div>
                                        <div class="mini-button"></div>
                                    </div>
                                    <div class="mini-features">
                                        <div class="mini-card"></div>
                                        <div class="mini-card"></div>
                                        <div class="mini-card"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tablet -->
                    <div class="device device-tablet">
                        <div class="device-frame">
                            <div class="device-screen">
                                <div class="screen-content">
                                    <div class="mini-header"></div>
                                    <div class="mini-hero">
                                        <div class="mini-title"></div>
                                        <div class="mini-button"></div>
                                    </div>
                                    <div class="mini-cards-row">
                                        <div class="mini-card-small"></div>
                                        <div class="mini-card-small"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tablet-button"></div>
                        </div>
                    </div>

                    <!-- Mobile -->
                    <div class="device device-mobile">
                        <div class="device-frame">
                            <div class="mobile-notch"></div>
                            <div class="device-screen">
                                <div class="screen-content">
                                    <div class="mini-header-mobile"></div>
                                    <div class="mini-hero-mobile">
                                        <div class="mini-title-mobile"></div>
                                        <div class="mini-button-mobile"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-bg-elements">
        <div class="bg-element bg-1"></div>
        <div class="bg-element bg-2"></div>
        <div class="bg-element bg-3"></div>
    </div>
</section>

