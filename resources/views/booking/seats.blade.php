@extends('layouts.app')

@section('title', 'Pilih Kursi - Bioskopku')

@section('content')

    <div class="section" style="padding-top:16px;">

        <div class="panel" style="margin-bottom:16px;">
            <h4 style="color: var(--merah); margin:0 0 6px;">{{ $showtime->movie->title }}</h4>
            <p class="section-sub" style="margin:0;">
                {{ $showtime->cinema->name }} ({{ $showtime->cinema->studio }})<br>
                {{ \Carbon\Carbon::parse($showtime->show_date)->translatedFormat('d M Y') }} &middot;
                {{ \Carbon\Carbon::parse($showtime->show_time)->format('H:i') }} &middot;
                Rp{{ number_format($showtime->price, 0, ',', '.') }} / kursi
            </p>
        </div>

        <form action="{{ route('booking.store', $showtime) }}" method="POST" id="bookingForm">
            @csrf

            <div class="screen-bar"></div>
            <p class="section-sub" style="text-align:center; margin-bottom:16px;">LAYAR</p>

            <div style="text-align:center; margin-bottom:16px;">
                @foreach ($seats->groupBy(fn($s) => substr($s->seat_code, 0, 1)) as $row => $rowSeats)
                    <div style="margin-bottom:2px;">
                        @foreach ($rowSeats as $seat)
                            <span
                                class="seat {{ $seat->is_booked ? 'booked' : '' }}"
                                data-id="{{ $seat->id }}"
                                data-price="{{ $showtime->price }}"
                                onclick="toggleSeat(this)"
                            >{{ $seat->seat_code }}</span>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <div style="display:flex; justify-content:center; gap:16px; font-size:12px; color:var(--abu); margin-bottom:20px;">
                <span><span class="seat" style="cursor:default; width:16px; height:16px; margin:0 4px 0 0; vertical-align:middle;"></span>Tersedia</span>
                <span><span class="seat selected" style="cursor:default; width:16px; height:16px; margin:0 4px 0 0; vertical-align:middle;"></span>Dipilih</span>
                <span><span class="seat booked" style="cursor:default; width:16px; height:16px; margin:0 4px 0 0; vertical-align:middle;"></span>Terisi</span>
            </div>

            <div class="panel">
                <div style="margin-bottom:12px;">
                    <label style="display:block; font-size:13px; color:var(--abu); margin-bottom:4px;">Nama Lengkap</label>
                    <input type="text" name="customer_name" required
                        style="width:100%; padding:10px 12px; border-radius:8px; border:1px solid #333; background:var(--hitam-soft); color:var(--putih);">
                </div>
                <div style="margin-bottom:12px;">
                    <label style="display:block; font-size:13px; color:var(--abu); margin-bottom:4px;">Email</label>
                    <input type="email" name="customer_email" required
                        style="width:100%; padding:10px 12px; border-radius:8px; border:1px solid #333; background:var(--hitam-soft); color:var(--putih);">
                </div>

                <div id="seatInputs"></div>

                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:16px;">
                    <div>
                        <div class="section-sub" style="margin:0;">Total</div>
                        <strong style="font-size:18px;">Rp<span id="totalPrice">0</span></strong>
                    </div>
                    <button type="submit" class="btn-merah" id="submitBtn" disabled>Konfirmasi Pemesanan</button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
<script>
    let selectedSeats = [];

    function toggleSeat(el) {
        if (el.classList.contains('booked')) return;

        const seatId = el.dataset.id;
        const price = parseFloat(el.dataset.price);

        if (el.classList.contains('selected')) {
            el.classList.remove('selected');
            selectedSeats = selectedSeats.filter(id => id !== seatId);
        } else {
            el.classList.add('selected');
            selectedSeats.push(seatId);
        }

        updateSummary(price);
    }

    function updateSummary(pricePerSeat) {
        document.getElementById('totalPrice').innerText =
            (selectedSeats.length * pricePerSeat).toLocaleString('id-ID');

        document.getElementById('submitBtn').disabled = selectedSeats.length === 0;

        const container = document.getElementById('seatInputs');
        container.innerHTML = '';
        selectedSeats.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'seats[]';
            input.value = id;
            container.appendChild(input);
        });
    }
</script>
@endsection