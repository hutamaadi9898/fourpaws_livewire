<?php

namespace App\Filament\Resources\Tributes;

use App\Filament\Resources\Tributes\Pages\CreateTribute;
use App\Filament\Resources\Tributes\Pages\EditTribute;
use App\Filament\Resources\Tributes\Pages\ListTributes;
use App\Filament\Resources\Tributes\Schemas\TributeForm;
use App\Filament\Resources\Tributes\Tables\TributesTable;
use App\Models\Tribute;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TributeResource extends Resource
{
    protected static ?string $model = Tribute::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TributeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TributesTable::configure($table);
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
            'index' => ListTributes::route('/'),
            'create' => CreateTribute::route('/create'),
            'edit' => EditTribute::route('/{record}/edit'),
        ];
    }
}
