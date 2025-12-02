<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static bool $shouldRegisterNavigation = true;
    
    protected static ?string $modelLabel = 'Страница';
    
    protected static ?string $pluralModelLabel = 'Страницы';
    
    protected static ?string $navigationLabel = 'Страницы';
    
    protected static ?string $navigationGroup = 'Контент';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Основная информация')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Название')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if (! $get('slug') || empty($get('slug'))) {
                                    $set('slug', \Illuminate\Support\Str::slug($state));
                                }
                            }),
                            
                        Forms\Components\TextInput::make('slug')
                            ->label('URL (slug)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(191)
                            ->helperText('Используется в URL страницы. Можно редактировать вручную.'),
                            
                        Forms\Components\Textarea::make('description')
                            ->label('Описание (SEO)')
                            ->rows(3)
                            ->maxLength(65535)
                            ->columnSpanFull(),
                            
                        Forms\Components\Toggle::make('is_active')
                            ->label('Активна')
                            ->default(true)
                            ->required(),
                    ]),

                Forms\Components\Section::make('Контент страницы')
                    ->schema([
                        Forms\Components\Builder::make('content')
                            ->label('Конструктор блоков')
                            ->blocks([
                                // 1. Hero Section
                                Forms\Components\Builder\Block::make('hero')
                                    ->label('Hero (Главный экран)')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_visible')
                                            ->label('Показывать блок')
                                            ->default(true),
                                        Forms\Components\RichEditor::make('title')
                                            ->label('Заголовок')
                                            ->required()
                                            ->toolbarButtons(['bold', 'italic', 'link']),
                                        Forms\Components\Textarea::make('subtitle')
                                            ->label('Подзаголовок'),
                                        Forms\Components\TextInput::make('button_text')
                                            ->label('Текст кнопки'),
                                        Forms\Components\TextInput::make('button_link')
                                            ->label('Ссылка кнопки'),
                                    ]),
                                
                                // 2. About Section
                                Forms\Components\Builder\Block::make('about')
                                    ->label('О нас (Manifesto)')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_visible')
                                            ->label('Показывать блок')
                                            ->default(true),
                                        Forms\Components\TextInput::make('title')
                                            ->label('Заголовок секции'),
                                        Forms\Components\Textarea::make('subtitle')
                                            ->label('Подзаголовок'),
                                        Forms\Components\RichEditor::make('manifesto_text')
                                            ->label('Текст манифеста')
                                            ->toolbarButtons(['bold', 'italic']),
                                        Forms\Components\Repeater::make('principles')
                                            ->label('Принципы (Карточки)')
                                            ->schema([
                                                Forms\Components\TextInput::make('icon_class')
                                                    ->label('CSS класс иконки (FontAwesome)')
                                                    ->default('fas fa-check'),
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Заголовок'),
                                                Forms\Components\Textarea::make('description')
                                                    ->label('Описание'),
                                            ])
                                            ->grid(3)
                                            ->collapsible(),
                                    ]),

                                // 3. Audit Section (Form)
                                Forms\Components\Builder\Block::make('audit')
                                    ->label('Аудит (Форма заявки)')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_visible')
                                            ->label('Показывать блок')
                                            ->default(true),
                                        Forms\Components\TextInput::make('title')
                                            ->label('Заголовок'),
                                        Forms\Components\Textarea::make('subtitle')
                                            ->label('Подзаголовок'),
                                        Forms\Components\Repeater::make('features')
                                            ->label('Список преимуществ (с галочками)')
                                            ->schema([
                                                Forms\Components\TextInput::make('icon_class')
                                                    ->label('CSS класс иконки'),
                                                Forms\Components\TextInput::make('text')
                                                    ->label('Текст'),
                                            ])
                                            ->defaultItems(3)
                                            ->collapsible(),
                                    ]),

                                // 4. Process Section (Timeline)
                                Forms\Components\Builder\Block::make('process')
                                    ->label('Процесс работы')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_visible')
                                            ->label('Показывать блок')
                                            ->default(true),
                                        Forms\Components\TextInput::make('title')
                                            ->label('Заголовок'),
                                        Forms\Components\Textarea::make('subtitle')
                                            ->label('Подзаголовок'),
                                        Forms\Components\Repeater::make('steps')
                                            ->label('Шаги')
                                            ->schema([
                                                Forms\Components\TextInput::make('step_number')
                                                    ->label('Номер шага (01, 02...)'),
                                                Forms\Components\TextInput::make('icon_class')
                                                    ->label('CSS класс иконки'),
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Заголовок шага'),
                                                Forms\Components\Textarea::make('description')
                                                    ->label('Описание'),
                                            ])
                                            ->grid(2)
                                            ->collapsible(),
                                    ]),

                                // 5. Guarantees Section
                                Forms\Components\Builder\Block::make('guarantees')
                                    ->label('Гарантии')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_visible')
                                            ->label('Показывать блок')
                                            ->default(true),
                                        Forms\Components\TextInput::make('title')
                                            ->label('Заголовок'),
                                        Forms\Components\Textarea::make('subtitle')
                                            ->label('Подзаголовок'),
                                        Forms\Components\Repeater::make('items')
                                            ->label('Карточки гарантий')
                                            ->schema([
                                                Forms\Components\Select::make('type')
                                                    ->label('Тип карточки')
                                                    ->options([
                                                        'success' => 'Позитивная (Зеленая/Синяя)',
                                                        'warning' => 'Предупреждение (Красная/Оранжевая)',
                                                    ])
                                                    ->default('success'),
                                                Forms\Components\TextInput::make('icon_class')
                                                    ->label('CSS класс иконки'),
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Заголовок'),
                                                Forms\Components\Textarea::make('description')
                                                    ->label('Описание'),
                                            ])
                                            ->grid(2)
                                            ->collapsible(),
                                    ]),
                                
                                // 6. Facts Section
                                Forms\Components\Builder\Block::make('facts')
                                    ->label('Факты (Цифры)')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_visible')
                                            ->label('Показывать блок')
                                            ->default(true),
                                        Forms\Components\Repeater::make('items')
                                            ->label('Факты')
                                            ->schema([
                                                Forms\Components\TextInput::make('icon_class')
                                                    ->label('CSS класс иконки'),
                                                Forms\Components\TextInput::make('number')
                                                    ->label('Цифра (Число)'),
                                                Forms\Components\TextInput::make('label')
                                                    ->label('Подпись'),
                                            ])
                                            ->grid(3)
                                            ->collapsible(),
                                    ]),
                                
                                // 7. Cozy CTA
                                Forms\Components\Builder\Block::make('cozy_cta')
                                    ->label('Cozy CTA (Telegram)')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_visible')
                                            ->label('Показывать блок')
                                            ->default(true),
                                        Forms\Components\TextInput::make('title')
                                            ->label('Заголовок'),
                                        Forms\Components\Textarea::make('subtitle')
                                            ->label('Подзаголовок'),
                                        Forms\Components\TextInput::make('button_text')
                                            ->label('Текст кнопки'),
                                        Forms\Components\TextInput::make('button_link')
                                            ->label('Ссылка'),
                                    ]),

                                // 8. Target Audience
                                Forms\Components\Builder\Block::make('target_audience')
                                    ->label('Целевая аудитория')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_visible')
                                            ->label('Показывать блок')
                                            ->default(true),
                                        Forms\Components\TextInput::make('title')
                                            ->label('Заголовок'),
                                        Forms\Components\Textarea::make('subtitle')
                                            ->label('Подзаголовок'),
                                        Forms\Components\Repeater::make('items')
                                            ->label('Аудитории')
                                            ->schema([
                                                Forms\Components\TextInput::make('icon_class')
                                                    ->label('CSS класс иконки'),
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Заголовок'),
                                                Forms\Components\Textarea::make('description')
                                                    ->label('Описание'),
                                                Forms\Components\Toggle::make('is_highlight')
                                                    ->label('Выделить карточку?')
                                                    ->default(false),
                                            ])
                                            ->grid(3)
                                            ->collapsible(),
                                    ]),

                                // 9. Advantages (Grid)
                                Forms\Components\Builder\Block::make('advantages')
                                    ->label('Преимущества (Сетка)')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_visible')
                                            ->label('Показывать блок')
                                            ->default(true),
                                        Forms\Components\TextInput::make('title')
                                            ->label('Заголовок'),
                                        Forms\Components\Textarea::make('subtitle')
                                            ->label('Подзаголовок'),
                                        Forms\Components\Repeater::make('items')
                                            ->label('Преимущества')
                                            ->schema([
                                                Forms\Components\TextInput::make('icon_class')
                                                    ->label('CSS класс иконки'),
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Заголовок'),
                                                Forms\Components\Textarea::make('description')
                                                    ->label('Описание'),
                                            ])
                                            ->grid(3)
                                            ->collapsible(),
                                    ]),

                                // 10. Portfolio
                                Forms\Components\Builder\Block::make('portfolio')
                                    ->label('Портфолио')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_visible')
                                            ->label('Показывать блок')
                                            ->default(true),
                                        Forms\Components\TextInput::make('title')
                                            ->label('Заголовок'),
                                        Forms\Components\Textarea::make('subtitle')
                                            ->label('Подзаголовок'),
                                        Forms\Components\Repeater::make('items')
                                            ->label('Кейсы')
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Название проекта'),
                                                Forms\Components\TextInput::make('description')
                                                    ->label('Краткое описание'),
                                                Forms\Components\FileUpload::make('image')
                                                    ->label('Скриншот')
                                                    ->image()
                                                    ->disk('public')
                                                    ->directory('page-blocks/portfolio'),
                                                Forms\Components\TextInput::make('url')
                                                    ->label('Ссылка на кейс (iframe url)'),
                                            ])
                                            ->grid(2)
                                            ->collapsible(),
                                    ]),
                                
                                // 11. Testimonials
                                Forms\Components\Builder\Block::make('testimonials')
                                    ->label('Отзывы')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_visible')
                                            ->label('Показывать блок')
                                            ->default(true),
                                        Forms\Components\TextInput::make('title')
                                            ->label('Заголовок'),
                                        Forms\Components\Textarea::make('subtitle')
                                            ->label('Подзаголовок'),
                                        Forms\Components\Repeater::make('items')
                                            ->label('Отзывы')
                                            ->schema([
                                                Forms\Components\TextInput::make('name')
                                                    ->label('Имя клиента'),
                                                Forms\Components\TextInput::make('role')
                                                    ->label('Роль/Ниша'),
                                                Forms\Components\Textarea::make('text')
                                                    ->label('Текст отзыва'),
                                                Forms\Components\Select::make('avatar_color')
                                                    ->label('Цвет аватара')
                                                    ->options([
                                                        'blue' => 'Blue',
                                                        'pink' => 'Pink',
                                                        'orange' => 'Orange',
                                                        'green' => 'Green',
                                                        'purple' => 'Purple',
                                                        'red' => 'Red',
                                                        'cyan' => 'Cyan',
                                                        'yellow' => 'Yellow',
                                                    ])
                                                    ->default('blue'),
                                            ])
                                            ->collapsible(),
                                    ]),

                                // 12. FAQ
                                Forms\Components\Builder\Block::make('faq')
                                    ->label('FAQ (Вопросы)')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_visible')
                                            ->label('Показывать блок')
                                            ->default(true),
                                        Forms\Components\TextInput::make('title')
                                            ->label('Заголовок'),
                                        Forms\Components\Textarea::make('subtitle')
                                            ->label('Подзаголовок'),
                                        Forms\Components\Repeater::make('items')
                                            ->label('Вопросы')
                                            ->schema([
                                                Forms\Components\TextInput::make('question')
                                                    ->label('Вопрос'),
                                                Forms\Components\RichEditor::make('answer')
                                                    ->label('Ответ'),
                                            ])
                                            ->collapsible(),
                                    ]),
                            ])
                            ->collapsible()
                            ->cloneable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('URL')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('URL скопирован'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активна')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создана')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Обновлена')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Активна'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
