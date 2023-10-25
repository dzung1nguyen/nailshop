<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use App\Models\PostCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Concerns\Translatable;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class PostResource extends Resource
{
    use Translatable;

    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 8;

    public static function getModelLabel(): string
    {
        return __('admin.post.posts');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.post.posts');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('admin.groups.blog');
    }

    public static function form(Form $form): Form
    {
        $components = request()->input('components');
        $locale = $components[0]['updates']['activeLocale'] ?? app()->getLocale();

        return $form
            ->schema([
                Forms\Components\Group::make()->columnSpan(['lg' => 2])
                    ->schema([
                        Forms\Components\Section::make()->schema([
                            Forms\Components\TextInput::make('title')
                                ->label(__('admin.post.columns.title'))
                                ->required(),

                            Forms\Components\Textarea::make('desciption')
                                ->label(__('admin.post.columns.desciption'))
                                ->required(),

                            Forms\Components\MarkdownEditor::make('content')
                                ->label(__('admin.post.columns.content'))
                                ->required(),
                        ]),

                        Forms\Components\Section::make('Image')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('image')->image()->hiddenLabel(),
                            ])
                            ->collapsible(),
                    ]),

                // Right column
                Forms\Components\Group::make()->columnSpan(['lg' => 1])
                    ->schema([
                        Forms\Components\Section::make(__('admin.post.setup'))
                            ->schema([
                                Forms\Components\Checkbox::make('featured')
                                    ->label(__('admin.post.columns.featured'))
                                    ->columnSpan('full'),

                                Forms\Components\Select::make('status')
                                    ->options([
                                        'draft' => __('admin.post.enums.draft'),
                                        'published' => __('admin.post.enums.published'),
                                    ])
                                    ->default('draft')
                                    ->selectablePlaceholder(false)
                                    ->required(),

                                Forms\Components\DatePicker::make('published_date')->requiredIf('status', 'published'),
                            ]),

                        Forms\Components\Section::make('Categories')
                            ->schema([
                                Forms\Components\CheckboxList::make('categories')
                                    ->required()
                                    ->hiddenLabel()
                                    ->relationship('categories', 'name_locale', fn (Builder $query) => $query->select('*', "name->$locale as name_locale")->orderBy('order', 'ASC'))
                            ]),
                    ]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label(__('admin.post.columns.id'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('title')->label(__('admin.post.columns.title')),
                Tables\Columns\SelectColumn::make('status')->label(__('admin.post.columns.status'))->options([
                    'draft' => __('admin.post.enums.draft'),
                    'published' => __('admin.post.enums.published'),
                ])->selectablePlaceholder(false),
                Tables\Columns\TextColumn::make('published_date')->label(__('admin.post.columns.published_date'))->date(),
                Tables\Columns\ToggleColumn::make('featured')->label(__('admin.post.columns.featured'))
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
