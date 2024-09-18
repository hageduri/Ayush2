<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IndicatorResource\Pages;
use App\Filament\Resources\IndicatorResource\RelationManagers;
use App\Models\Indicator;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class IndicatorResource extends Resource
{
    protected static ?string $model = Indicator::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nin')
                ->numeric()
                ->readOnly()
                ->default(Auth::user()->nin),

                TextInput::make('month')
                ->default(Carbon::now()->format('F-Y'))  // Format the current date as "Month-Year"
                ->readOnly(),

                TextInput::make('indicator_1')
                ->numeric()
                ->label('No.OPD cases in a month')
                ->required(),

                TextInput::make('indicator_2')
                ->numeric()
                ->label('No. of people underwent Prakriti Assessment')
                ->required(),

                TextInput::make('indicator_3')
                ->numeric()
                ->label('Portion of patient of DM on AYUSH Treatment')
                ->required(),

                TextInput::make('indicator_4')
                ->numeric()
                ->label('Portion of patient of HT on AYUSH Treatment')
                ->required(),

                TextInput::make('indicator_5')
                ->numeric()
                ->label('Population of above 30 years screen for HT ')
                ->required(),

                TextInput::make('indicator_6')
                ->numeric()
                ->label('No. of Individual empanelled in AYUSH Facilities ')
                ->required(),

                TextInput::make('indicator_7')
                ->numeric()
                ->label('Population of above 30 years screen for DM')
                ->required(),

                TextInput::make('indicator_8')
                ->numeric()
                ->label('Group session held at community level for AYUSH lifestyle counselling (15 persons/session)')
                ->required(),

                TextInput::make('indicator_9')
                ->numeric()
                ->label('Organizing/participating in inter sectoral meeting involving public. ')
                ->required(),

                TextInput::make('indicator_10')
                ->numeric()
                ->label('Conduct outreach programme & AYUSH Awareness for counselling & lifestyle modification. 3 (Three) campaigned in a month')
                ->required(),

                Hidden::make('status')
                ->default('submitted')





            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nin'),
                TextColumn::make('month'),
                TextColumn::make('status')
                ->alignCenter()
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    // 'draft' => 'gray',
                    // 'reviewing' => 'warning',
                    'submitted' => 'success',
                    'rejected' => 'danger',
                }),


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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIndicators::route('/'),
            'create' => Pages\CreateIndicator::route('/create'),
            'edit' => Pages\EditIndicator::route('/{record}/edit'),
        ];
    }
}
