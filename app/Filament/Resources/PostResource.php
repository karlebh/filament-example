<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-s-pencil';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              Forms\Components\TextInput::make('title')
              ->required()
              ->maxLength(255)
              ->columnSpanFull(),
              Forms\Components\Textarea::make('content')
              ->required()
              ->maxLength(20_000)
              ->rows(4)
              ->columnSpanFull(),
              Forms\Components\Select::make('user_id')
              ->relationship('user', 'name')
              ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              Tables\Columns\TextColumn::make('title'),
              Tables\Columns\TextColumn::make('created_at')
              ->formatStateUsing(function ($state) {
                return \Carbon\Carbon::parse($state)->diffForHumans();
            })
            ->sortable(),
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
          RelationManagers\CommentsRelationManager::class
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
