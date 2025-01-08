@extends('layouts.home')

@section('title', 'Proses Pembayaran')

@section('content')
<div class="container mx-auto py-12">
    <h1 class="text-3xl font-bold text-center mb-6">Proses Pembayaran</h1>
    <div class="text-center">
        <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                alert('Pembayaran berhasil!');
                window.location.href = "{{ route('order.confirmation', ['order' => $order->id]) }}";
            },
            onPending: function(result) {
                alert('Pembayaran tertunda.');
                window.location.href = "{{ route('order.confirmation', ['order' => $order->id]) }}";
            },
            onError: function(result) {
                alert('Pembayaran gagal.');
                console.error(result);
            },
            onClose: function() {
                alert('Anda menutup popup pembayaran.');
            }
        });
    };
</script>
@endsection

