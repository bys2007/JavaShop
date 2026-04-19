<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use \Filament\Forms;
use \Filament\Schemas\Schema;
use \Filament\Resources\Resource;
use \Filament\Tables;
use \Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-banknotes';
    protected static string | \UnitEnum | null $navigationGroup = 'Transaksi';
    protected static ?string $navigationLabel = 'Konfirmasi Bayar';
    protected static ?string $modelLabel = 'Pembayaran';
    protected static ?int $navigationSort = 2;
    protected static bool $shouldRegisterNavigation = false; // Disembunyikan — konfirmasi via menu Pesanan

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['order.user'])->orderByRaw("FIELD(status, 'pending', 'confirmed', 'rejected')"))
            ->columns([
                Tables\Columns\TextColumn::make('order.order_number')
                    ->label('No. Pesanan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('order.user.name')
                    ->label('Pelanggan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('method')
                    ->label('Metode')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'bank_transfer' => 'Transfer Bank',
                        'qris' => 'QRIS',
                        'midtrans' => 'Midtrans',
                        default => ucfirst($state),
                    }),

                Tables\Columns\ImageColumn::make('proof_image')
                    ->label('Bukti')
                    ->circular()
                    ->defaultImageUrl('https://placehold.co/40x40/F0E8D8/6B4C35?text=?'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'confirmed' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'pending' => 'Menunggu',
                        'confirmed' => 'Dikonfirmasi',
                        'rejected' => 'Ditolak',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Menunggu',
                        'confirmed' => 'Dikonfirmasi',
                        'rejected' => 'Ditolak',
                    ]),
            ])
            ->actions([
                \Filament\Actions\Action::make('confirm')
                    ->label('Konfirmasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Payment $record) => $record->status === 'pending')
                    ->action(function (Payment $record) {
                        $record->update([
                            'status' => 'confirmed',
                            'confirmed_at' => now(),
                            'confirmed_by' => auth()->id(),
                        ]);
                        $record->order->update(['status' => 'processing']);
                    }),
                \Filament\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Payment $record) => $record->status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Alasan')
                            ->required(),
                    ])
                    ->action(function (Payment $record, array $data) {
                        $record->update([
                            'status' => 'rejected',
                            'rejection_reason' => $data['rejection_reason'],
                        ]);
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
        ];
    }
}
