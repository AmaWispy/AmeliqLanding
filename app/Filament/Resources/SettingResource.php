<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static ?string $modelLabel = 'Настройки';
    
    protected static ?string $pluralModelLabel = 'Настройки';
    
    protected static ?string $navigationLabel = 'Настройки сайта';
    
    protected static ?string $navigationGroup = 'Система';
    
    protected static ?int $navigationSort = 999;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Настройки')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Основные')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\TextInput::make('site_name')
                                    ->label('Название сайта')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                    
                                Forms\Components\TextInput::make('site_title')
                                    ->label('Заголовок сайта (Title)')
                                    ->helperText('Отображается в заголовке браузера и поисковой выдаче')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                    
                                Forms\Components\Textarea::make('site_description')
                                    ->label('Описание сайта (Meta Description)')
                                    ->helperText('Краткое описание для поисковых систем (150-160 символов)')
                                    ->rows(3)
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                                    
                                Forms\Components\Textarea::make('site_keywords')
                                    ->label('Ключевые слова (Meta Keywords)')
                                    ->helperText('Ключевые слова через запятую')
                                    ->rows(2)
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                            ]),
                            
                        Forms\Components\Tabs\Tab::make('Изображения')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\FileUpload::make('favicon')
                                    ->label('Фавикон')
                                    ->helperText('Иконка сайта (рекомендуется 32x32px или 64x64px, .ico, .png)')
                                    ->image()
                                    ->directory('settings')
                                    ->acceptedFileTypes(['image/x-icon', 'image/png', 'image/jpeg'])
                                    ->columnSpanFull(),
                                    
                                Forms\Components\FileUpload::make('logo')
                                    ->label('Логотип')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('settings')
                                    ->columnSpanFull(),
                                    
                                Forms\Components\FileUpload::make('og_image')
                                    ->label('Open Graph изображение')
                                    ->helperText('Изображение для социальных сетей (рекомендуется 1200x630px)')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('settings')
                                    ->columnSpanFull(),
                            ]),
                            
                        Forms\Components\Tabs\Tab::make('Контакты')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                Forms\Components\TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->maxLength(255),
                                    
                                Forms\Components\TextInput::make('phone')
                                    ->label('Телефон')
                                    ->tel()
                                    ->maxLength(255),
                                    
                                Forms\Components\Textarea::make('address')
                                    ->label('Адрес')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ]),
                            
                        Forms\Components\Tabs\Tab::make('Социальные сети')
                            ->icon('heroicon-o-share')
                            ->schema([
                                Forms\Components\TextInput::make('telegram_url')
                                    ->label('Telegram')
                                    ->url()
                                    ->maxLength(255)
                                    ->placeholder('https://t.me/username')
                                    ->columnSpanFull(),
                                    
                                Forms\Components\TextInput::make('vk_url')
                                    ->label('ВКонтакте')
                                    ->url()
                                    ->maxLength(255)
                                    ->placeholder('https://vk.com/username')
                                    ->columnSpanFull(),
                                    
                                Forms\Components\TextInput::make('whatsapp_url')
                                    ->label('WhatsApp')
                                    ->url()
                                    ->maxLength(255)
                                    ->placeholder('https://wa.me/79001234567')
                                    ->helperText('Формат: https://wa.me/номер (без пробелов и +)')
                                    ->columnSpanFull(),
                                    
                                Forms\Components\TextInput::make('youtube_url')
                                    ->label('YouTube')
                                    ->url()
                                    ->maxLength(255)
                                    ->placeholder('https://youtube.com/@username')
                                    ->columnSpanFull(),
                            ]),
                            
                        Forms\Components\Tabs\Tab::make('Аналитика')
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                Forms\Components\Textarea::make('google_analytics')
                                    ->label('Google Analytics')
                                    ->helperText('Вставьте код Google Analytics (GA4)')
                                    ->rows(5)
                                    ->columnSpanFull(),
                                    
                                Forms\Components\Textarea::make('yandex_metrika')
                                    ->label('Яндекс Метрика')
                                    ->helperText('Вставьте код Яндекс Метрики')
                                    ->rows(5)
                                    ->columnSpanFull(),
                                    
                                Forms\Components\Textarea::make('google_tag_manager')
                                    ->label('Google Tag Manager')
                                    ->helperText('Вставьте код Google Tag Manager')
                                    ->rows(5)
                                    ->columnSpanFull(),
                                    
                                Forms\Components\Textarea::make('facebook_pixel')
                                    ->label('Facebook Pixel')
                                    ->helperText('Вставьте код Facebook Pixel')
                                    ->rows(5)
                                    ->columnSpanFull(),
                            ]),
                            
                        Forms\Components\Tabs\Tab::make('Дополнительно')
                            ->icon('heroicon-o-code-bracket')
                            ->schema([
                                Forms\Components\Textarea::make('head_scripts')
                                    ->label('Скрипты в <head>')
                                    ->helperText('Дополнительные скрипты или мета-теги для вставки в <head>')
                                    ->rows(5)
                                    ->columnSpanFull(),
                                    
                                Forms\Components\Textarea::make('body_scripts')
                                    ->label('Скрипты перед </body>')
                                    ->helperText('Дополнительные скрипты для вставки перед закрывающим тегом </body>')
                                    ->rows(5)
                                    ->columnSpanFull(),
                                    
                                Forms\Components\Textarea::make('robots_txt')
                                    ->label('Содержимое robots.txt')
                                    ->helperText('Правила для поисковых роботов')
                                    ->rows(10)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site_name')
                    ->label('Название сайта')
                    ->searchable(),
                Tables\Columns\TextColumn::make('site_title')
                    ->label('Заголовок')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Убираем массовое удаление
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSettings::route('/'),
        ];
    }
}
