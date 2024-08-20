<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\District;
use App\Models\Facility;
use App\Models\User;
use App\Policies\UserPolicy;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class UserResource extends Resource
{
    public string $rl;
    protected static ?string $model = User::class;
    protected static ?string $label = 'Staff';


    protected static ?string $navigationIcon = 'heroicon-o-users';

    // public static function form(Form $form): Form
    // {
    //     $usedNins = User::whereNotNull('nin')->pluck('nin')->toArray();
    //     // $available = Facility::whereNotIn('nin', $usedNins)->pluck('name', 'nin')->toArray();


    //     // dd($available);
    //     return $form
    //         ->schema([
    //             Tabs::make('Tabs')
    //             ->tabs([
    //                 Tabs\Tab::make('Profile')
    //                     ->schema([
    //                         TextInput::make('name')
    //                         ->autocapitalize()
    //                         ->required()
    //                         ->dehydrateStateUsing(fn ($state)=>strtoupper($state)),

    //                         TextInput::make('email')
    //                         ->required()
    //                         ->email()
    //                         ->unique(table: 'users', ignoreRecord: true),//email validation on update

    //                         TextInput::make('password')
    //                         ->password()
    //                         ->revealable()
    //                         ->required()->visibleOn('create'),

    //                         // TextInput::make('nin')
    //                         // ->numeric()
    //                         // ->visibleOn('edit'),

    //                         Select::make('nin')
    //                         ->options(Facility::whereNotIn('nin', $usedNins)->pluck('name', 'nin')->toArray())
    //                         ->searchable(),

    //                         Select::make('role')
    //                         ->required()
    //                         ->options([
    //                             // 'SupAdmin' => 'SupAdmin',
    //                             // 'Admin' => 'Admin',
    //                             'DMO' => 'DMO',
    //                             'MO' => 'MO',
    //                         ]),
    //                     ]),

    //                 Tabs\Tab::make('Personal Details')
    //                     ->schema([
    //                         Select::make('gender')
    //                         ->required()
    //                         ->options([
    //                             'Male' => 'Male',
    //                             'Female' => 'Female',
    //                         ]),
    //                         DatePicker::make('dob')
    //                         ->required(),


    //                         TextInput::make('contact_1')
    //                         ->label('Phone Number-1')
    //                         ->required()
    //                         ->tel(),

    //                         TextInput::make('contact_2')
    //                         ->label('Phone Number-2 (Optional)')
    //                         ->tel(),
    //                         TextInput::make('designation')
    //                         ->dehydrateStateUsing(fn ($state)=>strtoupper($state)),

    //                         Select::make('district_code')
    //                         ->label('District')
    //                         ->required()
    //                         ->options(
    //                             District::all()->pluck('district_name', 'district_code')->toArray()
    //                         ),

    //                         Textarea::make('address')
    //                         ->rows(6)
    //                         ->columns(10),

    //                     ])->visibleOn('edit'),


    //                 Tabs\Tab::make('Bank Details')
    //                     ->schema([
    //                         TextInput::make('bank_name')
    //                         ->required()
    //                         ->dehydrateStateUsing(fn ($state)=>strtoupper($state))
    //                         ,

    //                         TextInput::make('account_no')
    //                         ->label('Account Number')
    //                         ->required()
    //                         ->minLength(11)
    //                         ->numeric(),

    //                         TextInput::make('ifsc_code')
    //                         ->required()
    //                         ->maxLength(11)
    //                         ->dehydrateStateUsing(fn ($state)=>strtoupper($state)),
    //                     ])//->hidden(fn()=>Auth::user()->role=='SUPER')
    //                     ->visibleOn('edit'),
    //             ])->columns(2)
    //             ,


    //             // TextInput::make('status')->default('')
    //         ])->columns(1);
    // }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('facility.district.district_name'),
                TextColumn::make('facility.name'),
                TextColumn::make('name')->searchable()->sortable(),

                // TextColumn::make('email'),
                TextColumn::make('gender'),
                TextColumn::make('role'),
                TextColumn::make('contact_1')->label('Contact'),
                TextColumn::make('status'),

            ])
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->join('facilities', 'users.nin', '=', 'facilities.nin')
                ->join('districts', 'facilities.district_code', '=', 'districts.district_code')
                ->select('users.*', 'districts.district_name')
                ->orderBy('districts.district_name', 'asc')

            )
            ->filters([
                SelectFilter::make('role')
                            ->options([
                                // 'SupAdmin' => 'SupAdmin',
                                // 'Admin' => 'Admin',
                                'DMO' => 'DMO',
                                'MO' => 'MO',
                            ]),

                SelectFilter::make('district')
                ->label('Filter by District')
                ->options(fn () => District::pluck('district_name', 'district_code')->toArray())
                ->query(function (Builder $query, array $data) {
                    return $query->when(
                        $data['value'],
                        fn (Builder $query, $districtCode) => $query->whereHas('facility', fn ($q) => $q->where('district_code', $districtCode))
                    );
                })
            ], layout: FiltersLayout::AboveContent)





            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getModelPolicyName(): string
    {
        return UserPolicy::class;
    }
}
