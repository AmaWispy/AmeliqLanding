<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use App\Models\Setting;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class ManageSettings extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
    
    public function mount(int | string $record = null): void
    {
        // Получаем первую запись настроек или создаем новую
        $setting = Setting::first();
        
        if (!$setting) {
            $setting = Setting::create([]);
        }
        
        $this->record = $setting;
        
        $this->fillForm();
        
        $this->previousUrl = url()->previous();
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

