@extends('layouts.app')
@section('title', 'Pilih Metode Pembayaran')

@section('content')
<div class="bg-base min-h-screen py-12">
    <div class="container-main max-w-3xl">
        
        <div class="mb-8 flex items-center justify-between">
            <h1 class="font-display font-semibold text-2xl text-on-surface">Pilih Metode Pembayaran</h1>
            <span class="text-tertiary">#{{ $order->order_number }}</span>
        </div>

        <div class="card p-6 md:p-8 mb-6">
            <div class="flex items-start justify-between flex-wrap gap-4 mb-8">
                <div>
                    <p class="text-sm text-tertiary mb-1">Total Tagihan</p>
                    <p class="font-display font-semibold text-3xl text-primary">{{ $order->formatted_total }}</p>
                </div>
            </div>

            @if($order->status === 'pending_payment' && $order->payment_method === 'midtrans' && $snapToken)
                <div class="bg-warning/10 border border-warning/20 p-6 rounded-2xl mb-8 text-center bg-surface shadow-sm">
                    <p class="text-on-surface font-medium mb-2">Selesaikan Pembayaran Anda</p>
                    <p class="text-sm text-tertiary mb-6">Pilih QRIS, E-Wallet, Kartu Kredit, atau Gerai Minimarket via layanan aman Midtrans.</p>
                    <button type="button" id="pay-button" class="btn-primary w-full md:w-auto px-10">Bayar via Midtrans Sekarang</button>
                    <script src="https://app.{{ env('MIDTRANS_IS_PRODUCTION') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
                    <script type="text/javascript">
                        document.getElementById('pay-button').onclick = function(){
                            snap.pay('{{ $snapToken }}', {
                                onSuccess: function(result){
                                    // Notify our server immediately (webhook may not reach localhost)
                                    fetch('{{ route('api.midtrans.finish') }}', {
                                        method: 'POST',
                                        headers: { 'Content-Type': 'application/json' },
                                        body: JSON.stringify({
                                            order_id: result.order_id,
                                            transaction_id: result.transaction_id,
                                            transaction_status: result.transaction_status,
                                            payment_type: result.payment_type
                                        })
                                    }).finally(function() {
                                        window.location.href = "{{ route('order.success') }}?order={{ $order->order_number }}";
                                    });
                                },
                                onPending: function(result){
                                    window.location.reload();
                                },
                                onError: function(result){
                                    alert("Pembayaran Gagal! Silakan coba kembali.");
                                },
                                onClose: function(){
                                    console.log('Snap ditutup tanpa menyelesaikan pembayaran.');
                                }
                            });
                        };
                    </script>
                </div>
            @endif

            <div class="divider mb-6 text-xs text-tertiary font-medium tracking-widest uppercase">Atau Ganti Metode</div>

            <div class="grid md:grid-cols-2 gap-4">
                <form action="{{ route('checkout.update_method', $order->order_number) }}" method="POST">
                    @csrf
                    <input type="hidden" name="method" value="midtrans">
                    <button type="submit" class="w-full text-left p-5 border-2 rounded-xl transition-all {{ $order->payment_method === 'midtrans' ? 'border-primary bg-primary/5' : 'border-neutral hover:border-primary/50' }}">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-primary">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256"><path d="M216,48H40A16,16,0,0,0,24,64V192a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V64A16,16,0,0,0,216,48Zm0,144H40V96H216V192ZM216,80H40V64H216Zm-40,64a12,12,0,1,1-12-12A12,12,0,0,1,176,144Z"/></svg>
                            </div>
                            <span class="font-body font-semibold text-on-surface">Digital / Transfer Bank</span>
                        </div>
                        <p class="text-xs text-tertiary">QRIS, E-Wallet (GoPay, OVO), Virtual Account, & Gerai Retail.</p>
                    </button>
                </form>

                <form action="{{ route('checkout.update_method', $order->order_number) }}" method="POST">
                    @csrf
                    <input type="hidden" name="method" value="cod">
                    <button type="submit" class="w-full text-left p-5 border-2 rounded-xl transition-all {{ $order->payment_method === 'cod' ? 'border-primary bg-primary/5' : 'border-neutral hover:border-primary/50' }}">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-primary">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256"><path d="M245.54,124.93l-34.9-46.54A16,16,0,0,0,197.85,72H168V48a16,16,0,0,0-16-16H24A16,16,0,0,0,8,48V176a16,16,0,0,0,16,16H43.11a32,32,0,1,0,57.78,0h54.22a32,32,0,1,0,57.78,0H232a16,16,0,0,0,16-16V132a8,8,0,0,0-2.46-7.07ZM72,208a16,16,0,1,1,16-16A16,16,0,0,1,72,208Zm112,0a16,16,0,1,1,16-16A16,16,0,0,1,184,208Zm48-32H212.89a32,32,0,1,0-57.78,0H100.89a32,32,0,1,0-57.78,0H24V48H152v80a8,8,0,0,0,8,8h72Z"/></svg>
                            </div>
                            <span class="font-body font-semibold text-on-surface">Bayar di Tempat (COD)</span>
                        </div>
                        <p class="text-xs text-tertiary">Bayar pesanan secara tunai kepada kurir saat pesanan sampai.</p>
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</div>
@endsection
