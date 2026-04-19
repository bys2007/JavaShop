<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use \Filament\Actions;
use \Filament\Forms;
use \Filament\Infolists;
use \Filament\Schemas\Schema;
use \Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('Detail Pesanan')
                ->schema([
                    Infolists\Components\TextEntry::make('order_number')->label('No. Pesanan')->weight('bold'),
                    Infolists\Components\TextEntry::make('user.name')->label('Pelanggan'),
                    Infolists\Components\TextEntry::make('created_at')->label('Tanggal')->dateTime('d M Y, H:i'),
                    Infolists\Components\TextEntry::make('status')->label('Status')->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'pending_payment' => 'warning', 'processing' => 'info',
                            'shipped' => 'primary', 'delivered' => 'success',
                            'cancelled' => 'danger', default => 'gray',
                        }),
                ])->columns(4),

            \Filament\Schemas\Components\Section::make('Alamat Pengiriman')
                ->schema([
                    Infolists\Components\TextEntry::make('address.recipient_name')->label('Penerima'),
                    Infolists\Components\TextEntry::make('address.phone')->label('Telepon'),
                    Infolists\Components\TextEntry::make('address.full_formatted')->label('Alamat')->columnSpanFull(),
                ])->columns(2),

            \Filament\Schemas\Components\Section::make('Pembayaran')
                ->schema([
                    Infolists\Components\TextEntry::make('payment.method')->label('Metode'),
                    Infolists\Components\TextEntry::make('payment.bank_name')->label('Bank'),
                    Infolists\Components\TextEntry::make('payment.amount')->label('Jumlah')->money('IDR'),
                    Infolists\Components\TextEntry::make('payment.status')->label('Status Bayar')->badge()
                        ->color(fn (?string $state): string => match ($state) {
                            'confirmed' => 'success', 'pending' => 'warning',
                            'rejected' => 'danger', default => 'gray',
                        }),
                    Infolists\Components\ImageEntry::make('payment.proof_image')->label('Bukti Bayar')->height(200),
                ])->columns(2),

            \Filament\Schemas\Components\Section::make('Ringkasan')
                ->schema([
                    Infolists\Components\TextEntry::make('subtotal')->money('IDR'),
                    Infolists\Components\TextEntry::make('shipping_cost')->label('Ongkir')->money('IDR'),
                    Infolists\Components\TextEntry::make('discount')->label('Diskon')->money('IDR'),
                    Infolists\Components\TextEntry::make('total')->money('IDR')->weight('bold')->size('lg'),
                ])->columns(4),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('confirmPayment')
                ->label('Konfirmasi Pembayaran')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (Order $record) => $record->payment?->status === 'pending')
                ->action(function (Order $record) {
                    $record->payment->update([
                        'status' => 'confirmed',
                        'confirmed_at' => now(),
                        'confirmed_by' => auth()->id(),
                    ]);
                    $record->update(['status' => 'processing']);
                }),

            \Filament\Actions\Action::make('rejectPayment')
                ->label('Tolak Pembayaran')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn (Order $record) => $record->payment?->status === 'pending')
                ->form([
                    Forms\Components\Textarea::make('rejection_reason')
                        ->label('Alasan Penolakan')
                        ->required(),
                ])
                ->action(function (Order $record, array $data) {
                    $record->payment->update([
                        'status' => 'rejected',
                        'rejection_reason' => $data['rejection_reason'],
                    ]);
                }),

            \Filament\Actions\Action::make('updateStatus')
                ->label('Update Status')
                ->icon('heroicon-o-arrow-path')
                ->form([
                    Forms\Components\Select::make('status')
                        ->label('Status Baru')
                        ->required()
                        ->options([
                            'processing' => 'Diproses',
                            'shipped' => 'Dikirim',
                            'delivered' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ]),
                    Forms\Components\TextInput::make('tracking_number')
                        ->label('Nomor Resi')
                        ->visible(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get('status') === 'shipped'),
                ])
                ->action(function (Order $record, array $data) {
                    $update = ['status' => $data['status']];
                    if (!empty($data['tracking_number'])) {
                        $update['tracking_number'] = $data['tracking_number'];
                    }
                    $record->update($update);
                }),
        ];
    }
}
