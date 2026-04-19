<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use \Filament\Forms;
use \Filament\Schemas\Schema;
use \Filament\Resources\Resource;
use \Filament\Tables;
use \Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shopping-cart';
    protected static string | \UnitEnum | null $navigationGroup = 'Transaksi';
    protected static ?string $navigationLabel = 'Pesanan';
    protected static ?string $modelLabel = 'Pesanan';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('No. Pesanan')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('items_count')
                    ->label('Items')
                    ->counts('items')
                    ->badge(),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('payment.method')
                    ->label('Metode Bayar')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'bank_transfer' => 'Transfer Bank',
                        'qris'          => 'QRIS',
                        'midtrans'      => 'Midtrans',
                        null            => '-',
                        default         => ucfirst($state),
                    }),

                Tables\Columns\TextColumn::make('payment.status')
                    ->label('Pembayaran')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'confirmed' => 'success',
                        'pending'   => 'warning',
                        'rejected'  => 'danger',
                        default     => 'gray',
                    })
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'confirmed' => 'Lunas',
                        'pending'   => 'Menunggu',
                        'rejected'  => 'Ditolak',
                        null        => 'Belum Bayar',
                        default     => $state,
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status Pesanan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending_payment' => 'warning',
                        'processing'      => 'info',
                        'shipped'         => 'primary',
                        'delivered'       => 'success',
                        'cancelled'       => 'danger',
                        default           => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending_payment' => 'Menunggu Bayar',
                        'processing'      => 'Diproses',
                        'shipped'         => 'Dikirim',
                        'delivered'       => 'Selesai',
                        'cancelled'       => 'Dibatalkan',
                        default           => $state,
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending_payment' => 'Menunggu Pembayaran',
                        'processing'      => 'Diproses',
                        'shipped'         => 'Dikirim',
                        'delivered'       => 'Selesai',
                        'cancelled'       => 'Dibatalkan',
                    ]),
            ])
            ->actions([
                // ── Konfirmasi Pembayaran (jika payment pending) ──
                \Filament\Actions\Action::make('konfirmasi_bayar')
                    ->label('Konfirmasi Bayar')
                    ->icon('heroicon-o-banknotes')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Pembayaran')
                    ->modalDescription('Tandai pembayaran pesanan ini sudah diterima dan valid?')
                    ->visible(fn (Order $record): bool =>
                        $record->payment !== null && $record->payment->status === 'pending'
                    )
                    ->action(function (Order $record) {
                        $record->payment->update([
                            'status'       => 'confirmed',
                            'confirmed_at' => now(),
                            'confirmed_by' => auth()->id(),
                        ]);
                        $record->update(['status' => 'processing']);
                    }),

                // ── Proses → Kirim ──
                \Filament\Actions\Action::make('kirim')
                    ->label('Tandai Dikirim')
                    ->icon('heroicon-o-truck')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Tandai Pesanan Dikirim')
                    ->modalDescription('Pastikan pesanan sudah diserahkan ke kurir sebelum mengonfirmasi.')
                    ->visible(fn (Order $record): bool => $record->status === 'processing')
                    ->action(fn (Order $record) => $record->update(['status' => 'shipped'])),

                // ── Kirim → Selesai ──
                \Filament\Actions\Action::make('selesai')
                    ->label('Tandai Selesai')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Tandai Pesanan Selesai')
                    ->modalDescription('Konfirmasi bahwa pesanan sudah diterima oleh pelanggan.')
                    ->visible(fn (Order $record): bool => $record->status === 'shipped')
                    ->action(fn (Order $record) => $record->update(['status' => 'delivered'])),

                // ── Batalkan (hanya saat menunggu atau diproses) ──
                \Filament\Actions\Action::make('batalkan')
                    ->label('Batalkan')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Batalkan Pesanan')
                    ->modalDescription('Pesanan yang dibatalkan tidak dapat dikembalikan. Lanjutkan?')
                    ->visible(fn (Order $record): bool => in_array($record->status, ['pending_payment', 'processing']))
                    ->action(fn (Order $record) => $record->update(['status' => 'cancelled'])),

                \Filament\Actions\ViewAction::make()
                    ->label('Detail'),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view'  => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
