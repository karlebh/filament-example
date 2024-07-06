<?php

namespace App\Filament\Resources\PatientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TreatmentsRelationManager extends RelationManager
{
  protected static string $relationship = 'treatments';

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('desc')
          ->required()
          ->maxLength(255)
          ->columnSpanFull(),
        Forms\Components\Textarea::make('notes')
          ->maxLength(20_000)
          ->columnSpanFull(),
        Forms\Components\TextInput::make('price')
          ->maxValue(20_000)
          ->numeric()
          ->prefix('N')
          ->columnSpanFull(),
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('desc')
      ->columns([
        Tables\Columns\TextColumn::make('desc'),
        Tables\Columns\TextColumn::make('price')
          ->money('NGN')
          ->sortable(),
        Tables\Columns\TextColumn::make('created_at')
          ->dateTime('m-d-Y'),

      ])
      ->filters([
        //
      ])
      ->headerActions([
        Tables\Actions\CreateAction::make(),
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
}
