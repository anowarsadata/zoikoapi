<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function form(Form $form): Form
    {
        $statusOptions = [
            0 => 'In-active',
            1 => 'Active',
        ];

        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->required()->email()->unique(),
                TextInput::make('password')->required()->password(),
                Select::make('roles')
                    ->label('User Role')
                    ->relationship('roles', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false),
                Select::make('status')
                    ->label('Status')
                    ->options($statusOptions)
                    ->required()
                    ->native(false),
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Prevent trying to save 'roles' directly to the users table
        unset($data['roles']);

        // Encrypt password before save
        $data['password'] = bcrypt($data['password']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->syncRoles($this->form->getState()['roles']);
    }
}
