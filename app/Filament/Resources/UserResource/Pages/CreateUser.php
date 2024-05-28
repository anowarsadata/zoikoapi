<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    public function form(Form $form): Form
    {
        $roles = DB::table('roles')->pluck('name', 'id');
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->required()->unique(),
                TextInput::make('password')->required(),
                Select::make('role_id')
                    ->label('User Role')
                    ->options($roles)
                    ->searchable(),
            ]);
    }
}
