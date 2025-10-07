<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlockResource\Pages;
use App\Filament\Resources\BlockResource\RelationManagers;
use App\Models\Block;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlockResource extends Resource
{
    protected static ?string $model = Block::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $modelLabel = 'Блок';
    
    protected static ?string $pluralModelLabel = 'Блоки';
    
    protected static ?string $navigationLabel = 'Блоки';
    
    protected static ?string $navigationGroup = 'Контент';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Заголовок')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                    
                Forms\Components\TextInput::make('key')
                    ->label('Ключ')
                    ->maxLength(255)
                    ->helperText('Уникальный ключ для идентификации блока'),
                    
                Forms\Components\TextInput::make('anchor')
                    ->label('Якорь')
                    ->maxLength(255)
                    ->helperText('Якорь для прокрутки к блоку (например: #about)'),
                    
                Forms\Components\FileUpload::make('photo')
                    ->label('Фото')
                    ->image()
                    ->imageEditor()
                    ->directory('blocks/photos')
                    ->columnSpanFull(),
                    
                Forms\Components\FileUpload::make('video')
                    ->label('Видео')
                    ->acceptedFileTypes(['video/mp4', 'video/mpeg', 'video/quicktime', 'video/webm'])
                    ->directory('blocks/videos')
                    ->columnSpanFull(),
                    
                Forms\Components\Repeater::make('fields')
                    ->label('Поля')
                    ->schema([
                        Forms\Components\TextInput::make('id')
                            ->label('ID')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('content')
                            ->label('Контент')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                                'blockquote',
                                'codeBlock',
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->defaultItems(0)
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['id'] ?? null)
                    ->columnSpanFull()
                    ->addActionLabel('Добавить поле'),
                    
                Forms\Components\TextInput::make('order')
                    ->label('Порядок сортировки')
                    ->numeric()
                    ->default(0)
                    ->required(),
                    
                Forms\Components\Toggle::make('is_active')
                    ->label('Активен')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('key')
                    ->label('Ключ')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('anchor')
                    ->label('Якорь')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Фото')
                    ->circular()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('video')
                    ->label('Видео')
                    ->boolean()
                    ->getStateUsing(fn ($record) => !empty($record->video))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('order')
                    ->label('Порядок')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активен')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Обновлён')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Активен'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBlocks::route('/'),
            'create' => Pages\CreateBlock::route('/create'),
            'edit' => Pages\EditBlock::route('/{record}/edit'),
        ];
    }
}
