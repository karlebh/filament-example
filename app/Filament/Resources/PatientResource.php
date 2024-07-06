<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportConsoleCommands\Commands\FormCommand;


class PatientResource extends Resource
{
  protected static ?string $model = Patient::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('name')
          ->required()
          ->maxLength(255),
        Forms\Components\Select::make('type')->options([
          'dog' => 'Dog',
          'cat' => 'Cat',
          'rabbit' => 'Rabbit',
        ])->required(),
        Forms\Components\DatePicker::make('dob')->required()->maxDate(now()),
        Forms\Components\Select::make('owner_id')
          ->relationship('owner', 'name')
          ->searchable()
          ->preload()
          ->createOptionForm([
            Forms\Components\TextInput::make('name')
              ->required()
              ->maxLength(255),
            Forms\Components\TextInput::make('email')
              ->email()
              ->label('Email Address')
              ->required()
              ->maxLength(255),
            Forms\Components\TextInput::make('phone')
              ->tel()
              ->label('Phone Number')
              ->required()
          ])
          ->required()
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('name')->searchable(),
        Tables\Columns\TextColumn::make('type')->label('Pet'),
        Tables\Columns\TextColumn::make('dob')->label('Date Of Birth'),
        Tables\Columns\TextColumn::make('owner.name')->searchable(),
      ])
      ->filters([
        Tables\Filters\SelectFilter::make('type')
          ->options([
            'cat' => 'Cat',
            'dog' => 'Dog',
            'rabbit' => 'Rabbit'
          ])
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
      RelationManagers\TreatmentsRelationManager::class
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListPatients::route('/'),
      'create' => Pages\CreatePatient::route('/create'),
      'edit' => Pages\EditPatient::route('/{record}/edit'),
    ];
  }
}
