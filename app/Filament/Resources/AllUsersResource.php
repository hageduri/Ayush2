<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AllUsersResource\Pages;
use App\Filament\Resources\AllUsersResource\RelationManagers;
use App\Models\AllUsers;
use App\Models\District;
use App\Models\Facility;
use App\Models\User;
use App\Policies\AllUsersPolicy;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AllUsersResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $usedNins = User::whereNotNull('nin')->pluck('nin')->toArray();
        return $form
        ->schema([
            Tabs::make('Tabs')
            ->tabs([
                Tabs\Tab::make('Profile')
                    ->schema([
                        TextInput::make('name')
                        ->autocapitalize()
                        ->required()
                        ->dehydrateStateUsing(fn ($state)=>strtoupper($state)),

                        TextInput::make('email')
                        ->required()
                        ->email()
                        ->unique(table: 'users', ignoreRecord: true),//email validation on update

                        TextInput::make('password')
                        ->password()
                        ->revealable()
                        ->required()->visibleOn('create'),

                        // TextInput::make('nin')
                        // ->numeric()
                        // ->visibleOn('edit'),

                        Select::make('nin')
                        ->options(Facility::whereNotIn('nin', $usedNins)->pluck('name', 'nin')->toArray())
                        ->searchable(),

                        Select::make('role')
                        ->required()
                        ->options([
                            // 'SupAdmin' => 'SupAdmin',
                            // 'Admin' => 'Admin',
                            'DMO' => 'DMO',
                            'MO' => 'MO',
                        ]),
                    ]),

                Tabs\Tab::make('Personal Details')
                    ->schema([
                        Select::make('gender')
                        ->required()
                        ->options([
                            'Male' => 'Male',
                            'Female' => 'Female',
                        ]),
                        DatePicker::make('dob')
                        ->required(),


                        TextInput::make('contact_1')
                        ->label('Phone Number-1')
                        ->required()
                        ->tel(),

                        TextInput::make('contact_2')
                        ->label('Phone Number-2 (Optional)')
                        ->tel(),
                        TextInput::make('designation')
                        ->dehydrateStateUsing(fn ($state)=>strtoupper($state)),

                        Select::make('district_code')
                        ->label('District')
                        ->required()
                        ->options(
                            District::all()->pluck('district_name', 'district_code')->toArray()
                        ),

                        Textarea::make('address')
                        ->rows(6)
                        ->columns(10),

                    ])->visibleOn('edit'),


                Tabs\Tab::make('Bank Details')
                    ->schema([
                        TextInput::make('bank_name')
                        ->required()
                        ->dehydrateStateUsing(fn ($state)=>strtoupper($state))
                        ,

                        TextInput::make('account_no')
                        ->label('Account Number')
                        ->required()
                        ->minLength(11)
                        ->numeric(),

                        TextInput::make('ifsc_code')
                        ->required()
                        ->maxLength(11)
                        ->dehydrateStateUsing(fn ($state)=>strtoupper($state)),
                    ])//->hidden(fn()=>Auth::user()->role=='SUPER')
                    ->visibleOn('edit'),
            ])->columns(2)
            ,


            // TextInput::make('status')->default('')
        ])->columns(1);
    }

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
            'index' => Pages\ListAllUsers::route('/'),
            'create' => Pages\CreateAllUsers::route('/create'),
            'edit' => Pages\EditAllUsers::route('/{record}/edit'),
        ];
    }
    public static function getModelPolicyName(): string
    {
        return AllUsersPolicy::class;
    }
}
