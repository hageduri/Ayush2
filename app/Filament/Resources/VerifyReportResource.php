<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VerifyReportResource\Pages;
use App\Filament\Resources\VerifyReportResource\RelationManagers;
use App\Models\Facility;
use App\Models\VerifyReport;

use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class VerifyReportResource extends Resource
{
    protected static ?string $model = Facility::class;

    protected static ?string $label = 'Verify Report';
    public static function canViewAny(): bool
    {
        return Auth::user()->can('viewReport', Facility::class);
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label('Facility Name')
                ->sortable()
                ->weight(FontWeight::Bold)
                ->searchable(),

                TextColumn::make('user.name')
                ->label('Incharge')
                ->default('Not Assigned')
                ->colors([
                    'warning' => 'Not Assigned',
                ]),

                TextColumn::make('indicator.status')
                    ->label('Indicator Status')
                    ->sortable()
                    ->default('pending')
                    ->alignCenter()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        // 'draft' => 'gray',
                        'pending' => 'warning',
                        'submitted' => 'success',
                        'rejected' => 'danger',
                    }),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                // Filter by the DMO's district
                return $query
                ->with('indicator')
                ->whereHas('district', function ($query) {
                    $query->where('district_code', Auth::user()->district_code);
                });
            })

            ->filters([
                //
            ])
            ->actions([
                Action::make('Verify')
                ->link()
                ->icon('heroicon-s-document-check')
                ->color('danger')
                ->form([
                    Select::make('indicator.status')
                        ->label('Status')
                        ->options([
                            'approved'=>'Approve',
                            'rejected'=>'Reject'
                        ])
                        ,
                ]),

                ViewAction::make()
                ->form([
                    TextInput::make('name')
                        ->label('Facility Name')
                        ->disabled(),

                    Repeater::make('indicator')
                        ->schema([

                            TextInput::make('status')
                                ->label('Status')
                                ->disabled()
                                ->default('Pending'),

                            TextInput::make('indicator_1')
                            ->label('Indicator 1')
                            ->disabled()
                            ,

                        ])
                        ->disabled()
                        ->label('Indicators')
                        ->columns(3),
                ])
                ->modalHeading('Facility Details')
                ->modalDescription('View facility and its indicators')
                ->modalWidth('4xl')
                ->mutateRecordDataUsing(function (array $data): array {
                    $facility = Facility::with('indicator', 'user')->find($data['id']);
                    $data['indicator'] = $facility->indicator->map(function ($indicator) {
                        return [

                            'status' => $indicator->status,
                            'indicator_1' => $indicator->indicator_1,
                            'indicator_2' => $indicator->indicator_2,
                            'indicator_3' => $indicator->indicator_3,
                            'indicator_4' => $indicator->indicator_4,
                            'indicator_5' => $indicator->indicator_5,
                            'indicator_6' => $indicator->indicator_6,
                            'indicator_7' => $indicator->indicator_7,
                            'indicator_8' => $indicator->indicator_8,
                            'indicator_9' => $indicator->indicator_9,
                            'indicator_10' => $indicator->indicator_10,
                            'month' => $indicator->month,
                            'remarks' => $indicator->remarks,

                        ];
                    })->toArray();
                    return $data;
                }),



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
            'index' => Pages\ListVerifyReports::route('/'),
            'create' => Pages\CreateVerifyReport::route('/create'),
            'edit' => Pages\EditVerifyReport::route('/{record}/edit'),
        ];
    }
}
