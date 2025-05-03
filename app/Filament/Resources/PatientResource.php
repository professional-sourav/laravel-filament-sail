<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers\TreatmentsRelationManager;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static int $globalSearchResultsLimit = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'type'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Owner' => $record->owner->name,
            'Date of Birth' => $record->date_of_birth->format('d/m/Y'),
            'Type' => $record->type,
            'Treatments' => $record->treatments->count(),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with(['owner', 'treatments']);
    }

    /*public static function getGlobalSearchResultActions(Model $record): array
    {
        return [
            Tables\Actions\EditAction::make()
                ->url(static::getUrl('edit', ['record' => $record])),
        ];
    }*/

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\DatePicker::make('date_of_birth')
                    ->required()
                    ->maxDate(now()->subYears(18))
                    ->label('Date of Birth'),

                Forms\Components\Select::make('type')
                    ->options([
                        'adult' => 'Adult',
                        'child' => 'Child',
                    ])
                    ->required()
                    ->label('Patient Type'),

                Forms\Components\Select::make('owner_id')
                    ->relationship('owner', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Owner')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->maxLength(15),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('owner.name')
                    ->label('Owner')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'adult' => 'Adult',
                        'child' => 'Child',
                    ])
                    ->label('Patient Type'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            TreatmentsRelationManager::class,
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
