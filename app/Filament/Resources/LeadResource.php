<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    
    protected static ?string $modelLabel = 'Заявка';
    
    protected static ?string $pluralModelLabel = 'Заявки';
    
    protected static ?string $navigationLabel = 'Заявки с сайта';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Данные заявки')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Имя'),
                        
                        Forms\Components\TextInput::make('phone')
                            ->label('Телефон')
                            ->helperText('Зашифровано в БД'),
                            
                        Forms\Components\TextInput::make('email')
                            ->label('Email'),
                            
                        Forms\Components\TextInput::make('source')
                            ->label('Источник'),
                            
                        Forms\Components\Textarea::make('message')
                            ->label('Сообщение')
                            ->columnSpanFull(),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Техническая информация')
                    ->schema([
                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP адрес'),
                        Forms\Components\TextInput::make('user_agent')
                            ->label('User Agent'),
                        Forms\Components\KeyValue::make('payload')
                            ->label('Все данные')
                            ->columnSpanFull(),
                    ])->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('source')
                    ->label('Источник')
                    ->badge()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListLeads::route('/'),
            // 'create' => Pages\CreateLead::route('/create'), // Отключаем создание вручную, если не нужно
            // 'edit' => Pages\EditLead::route('/{record}/edit'), // Можно оставить только просмотр
        ];
    }
    
    public static function canCreate(): bool
    {
        return false; // Запрещаем создание заявок вручную
    }
}
