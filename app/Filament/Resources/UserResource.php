<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    // https://heroicons.com/
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'email';

    public static function getModelLabel(): string
    {
        return __('admin.user.users');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.user.users');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('admin.groups.system');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('admin.user.columns.name'))
                    ->required()
                    ->maxLength(100),

                Forms\Components\TextInput::make('email')
                    ->label(__('admin.user.columns.email'))
                    ->email()
                    ->required()
                    ->maxLength(191)
                    ->unique(ignorable: fn ($record) => $record),

                Forms\Components\TextInput::make('password')
                    ->label(__('admin.user.columns.password'))
                    ->password()
                    ->minLength(6)
                    ->maxLength(100)
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label(__('admin.user.columns.id'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->label(__('admin.user.columns.name'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label(__('admin.user.columns.email'))->searchable()->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
