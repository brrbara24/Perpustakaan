<?php

namespace App\Filament\Resources\Loans;

use App\Filament\Resources\Loans\Pages\CreateLoan;
use App\Filament\Resources\Loans\Pages\EditLoan;
use App\Filament\Resources\Loans\Pages\ListLoans;
use App\Models\Loan;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static ?string $navigationLabel = 'Transaksi';
    protected static ?string $modelLabel = 'Transaksi';
    protected static ?string $pluralModelLabel = 'Transaksi';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('user_id')
                ->label('Anggota')
                ->relationship('user', 'name', fn (Builder $query) => $query->where('role', 'siswa'))
                ->searchable()->preload()->required(),
            Select::make('book_id')
                ->label('Buku')
                ->relationship('book', 'title')
                ->searchable()->preload()->required(),
            DatePicker::make('loan_date')
                ->label('Tanggal Pinjam')->default(now())->required(),
            DatePicker::make('due_date')
                ->label('Jatuh Tempo')->default(now()->addDays(7))->required(),
            DatePicker::make('returned_at')
                ->label('Tanggal Kembali'),
            Select::make('status')
                ->options([
                    'dipinjam' => 'Dipinjam',
                    'dikembalikan' => 'Dikembalikan',
                ])
                ->default('dipinjam')->required(),
            TextInput::make('fine')
                ->label('Denda')->numeric()->prefix('Rp')->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Anggota')->searchable(),
                TextColumn::make('book.title')->label('Buku')->searchable(),
                TextColumn::make('loan_date')->label('Tgl Pinjam')->date('d M Y')->sortable(),
                TextColumn::make('due_date')->label('Jatuh Tempo')->date('d M Y'),
                TextColumn::make('returned_at')->label('Dikembalikan')->date('d M Y'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => $state === 'dipinjam' ? 'warning' : 'success'),
                TextColumn::make('fine')->label('Denda')->money('IDR'),
            ])
            ->defaultSort('id', 'desc')
            ->recordActions([
                Action::make('kembalikan')
                    ->label('Kembalikan')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->visible(fn (Loan $record) => $record->status === 'dipinjam')
                    ->requiresConfirmation()
                    ->action(fn (Loan $record) => $record->returnBook()),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLoans::route('/'),
            'create' => CreateLoan::route('/create'),
            'edit' => EditLoan::route('/{record}/edit'),
        ];
    }
}
