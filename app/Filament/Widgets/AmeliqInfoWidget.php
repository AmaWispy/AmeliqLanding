<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class AmeliqInfoWidget extends Widget
{
    protected static string $view = 'filament.widgets.ameliq-info-widget';

    protected static ?int $sort = 3; // Показываем в самом низу
    
    // Растягиваем на всю ширину при желании, или оставляем компактным
    protected int | string | array $columnSpan = 'full';
}
