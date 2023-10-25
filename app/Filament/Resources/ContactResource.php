<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-hand-raised';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('admin.contact.contacts');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.contact.contacts');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('admin.contact.columns.name'))
                    ->readOnly()
                    ->required(),

                Forms\Components\TextInput::make('phone')
                    ->readOnly()
                    ->label(__('admin.contact.columns.phone')),

                Forms\Components\TextInput::make('email')
                    ->label(__('admin.contact.columns.email'))
                    ->readOnly()
                    ->required(),

                Forms\Components\Textarea::make('message')
                    ->label(__('admin.contact.columns.message'))
                    ->rows(4)
                    ->readOnly()
                    ->required()
                    ->columnSpan('full'),

                Forms\Components\Textarea::make('note')
                    ->label(__('admin.contact.columns.note'))
                    ->columnSpan('full')
                    ->requiredIf('status', 'processed'),

                Forms\Components\Select::make('status')->label(__('admin.contact.columns.status'))->options([
                    'new' => __('admin.contact.enums.new'),
                    'pending' => __('admin.contact.enums.pending'),
                    'processed' => __('admin.contact.enums.processed'),
                ])->required()
                ->selectablePlaceholder(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label(__('admin.contact.columns.id'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->label(__('admin.contact.columns.name')),
                Tables\Columns\TextColumn::make('phone')->label(__('admin.contact.columns.phone')),
                Tables\Columns\TextColumn::make('email')->label(__('admin.contact.columns.email')),
                Tables\Columns\TextColumn::make('status')->label(__('admin.contact.columns.status'))->formatStateUsing(fn (string $state): string => __("admin.contact.enums.{$state}")),
                Tables\Columns\TextColumn::make('created_at')->label(__('admin.contact.columns.created_at'))->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageContacts::route('/'),
        ];
    }
}
