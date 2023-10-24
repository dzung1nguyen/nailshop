<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostCategoryResource\Pages;
use App\Filament\Resources\PostCategoryResource\RelationManagers;
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

class PostCategoryResource extends Resource
{
    use Translatable;

    protected static ?string $model = PostCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

     public static function getModelLabel(): string
     {
         return __('admin.post_category.post_categories');
     }

     public static function getNavigationLabel(): string
     {
         return __('admin.post_category.post_categories');
     }

     public static function getNavigationGroup(): ?string
     {
         return __('admin.groups.blog');
     }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                        ->label(__('admin.post_category.columns.name'))
                        ->required(),

                Forms\Components\TextInput::make('slug')
                        ->label(__('admin.post_category.columns.slug'))
                        ->required(),

                Forms\Components\TextInput::make('order')
                    ->label(__('admin.post_category.columns.order'))
                    ->numeric()
                    ->minValue(0)
                    ->required(),

                SpatieMediaLibraryFileUpload::make('avatar')->image()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label(__('admin.post_category.columns.id'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->label(__('admin.post_category.columns.name')),
                Tables\Columns\TextColumn::make('order')->label(__('admin.post_category.columns.order')),
            ])
            ->filters([
                //
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
            'index' => Pages\ListPostCategories::route('/'),
            'create' => Pages\CreatePostCategory::route('/create'),
            'edit' => Pages\EditPostCategory::route('/{record}/edit'),
        ];
    }
}
