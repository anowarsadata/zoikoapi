<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserAddressResource\Pages;
use App\Models\UserAddress;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class UserAddressResource extends Resource
{
    protected static ?string $model = UserAddress::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function form(Form $form): Form
{
    $cityOptions = \App\Models\UserAddress::query()->distinct()->pluck('city', 'city')->filter()->toArray();
    $stateOptions = \App\Models\UserAddress::query()->distinct()->pluck('state', 'state')->filter()->toArray();
    $countryOptions = \App\Models\UserAddress::query()->distinct()->pluck('country', 'country')->filter()->toArray();

    return $form->schema([
        Select::make('user_id')
            ->relationship('user', 'name')
            ->required(),

        TextInput::make('street')->required(),
        TextInput::make('zip_code')->required(),

        Select::make('city')
            ->label('City')
            ->options($cityOptions)
            ->searchable()
            ->required(),

        Select::make('state')
            ->label('State')
            ->options($stateOptions)
            ->searchable()
            ->required(),

        Select::make('country')
            ->label('Country')
            ->options($countryOptions)
            ->searchable()
            ->required(),

        TextInput::make('phone')->required(),
        TextInput::make('type')->label('Address Type')->required(),
    ]);
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User'),
                TextColumn::make('street'),
                TextColumn::make('zip_code'),
                TextColumn::make('city'),
                TextColumn::make('state'),
                TextColumn::make('country'),
                TextColumn::make('phone'),
                TextColumn::make('type'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('country')
                    ->options(
                        UserAddress::query()->distinct()->pluck('country', 'country')->toArray()
                    )
                    ->label('Filter by Country'),

                Tables\Filters\SelectFilter::make('state')
                    ->options(
                        UserAddress::query()->distinct()->pluck('state', 'state')->toArray()
                    )
                    ->label('Filter by State'),

                Tables\Filters\SelectFilter::make('city')
                    ->options(
                        UserAddress::query()->distinct()->pluck('city', 'city')->toArray()
                    )
                    ->label('Filter by City'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserAddresses::route('/'),
            'create' => Pages\CreateUserAddress::route('/create'),
            'edit' => Pages\EditUserAddress::route('/{record}/edit'),
        ];
    }
}
