<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    public function form(Form $form): Form
    {
        $roles = DB::table('roles')->pluck('name', 'id');
        $status = array('0' => 'In-active', '1' => 'Active');
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->required(),
                Select::make('role_id')
                    ->required()
                    ->label('User Role')
                    ->options($roles),
                Select::make('status')
                    ->required()
                    ->label('Status')
                    ->options($status)
            ]);
    }
}
