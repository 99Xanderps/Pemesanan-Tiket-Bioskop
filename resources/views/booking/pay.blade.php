@extends('layouts.app')

@section('title', 'Pembayaran - Bioskopku')

@section('content')

    <div class="section">
        <div class="section-head">
            <h4>Pembayaran</h4>
        </div>

        <div class="panel" style="margin-bottom:16px;">
            <div style="font-weight:700; font-size:15px; margin-bottom:4px;">{{ $booking->showtime->movie->title }}</div>
            <div class="section-sub">
                {{ $booking->showtime->cinema->name }} &middot;
                {{ \Illuminate\Support\Carbon::parse($booking->showtime->show_date)->translatedFormat('d M Y') }},
                {{ \Illuminate\Support\Carbon::parse($booking->showtime->show_time)->format('H:i') }}
            </div>
            <div class="section-sub" style="margin-top:4px;">
                Kursi: {{ $booking->seats->pluck('seat_code')->join(', ') }}
            </div>

            <div style="border-top:1px solid #2a2a2a; margin:14px 0; padding-top:14px; display:flex; justify-content:space-between; font-weight:700;">
                <span>Total Bayar</span>
                <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <form method="POST" action="{{ route('booking.confirmPay', $booking) }}">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <p class="section-sub" style="margin-bottom:10px;">Pilih Metode Pembayaran</p>

            <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:20px;">
                @foreach ([
                    'transfer_bca'     => 'Transfer Bank BCA',
                    'transfer_mandiri' => 'Transfer Bank Mandiri',
                    'ovo'              => 'OVO',
                    'gopay'            => 'GoPay',
                ] as $value => $label)
                    <label class="panel" style="display:flex; align-items:center; gap:10px; cursor:pointer; padding:12px 14px;">
                        <input type="radio" name="metode" value="{{ $value }}" required>
                        {{ $label }}
                    </label>
                @endforeach
            </div>

            <button type="submit" class="btn-merah" style="width:100%;">Konfirmasi Pembayaran</button>
        </form>
    </div>

@endsection
