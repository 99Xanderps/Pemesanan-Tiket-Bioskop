@extends('layouts.app')

@section('title', 'Pilih Kursi - Bioskopku')

@section('content')

    <div class="section">
        <div class="section-head">
            <h4>🎬 {{ $showtime->movie->title }}</h4>
        </div>
        <p class="section-sub">
            {{ $showtime->cinema->name }} &middot;
            {{ \Illuminate\Support\Carbon::parse($showtime->show_date)->translatedFormat('d M Y') }},
            {{ \Illuminate\Support\Carbon::parse($showtime->show_time)->format('H:i') }}
        </p>

        <div class="screen-bar"></div>
        <p class="section-sub" style="text-align:center; margin-top:-8px;">LAYAR</p>

        <form method="POST" action="{{ route('booking.store', $showtime) }}" id="seatForm">
            @csrf

            <div id="hiddenSeatInputs"></div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <div style="text-align:center; margin: 16px 0;">
                @foreach ($seats as $row => $seatsInRow)
                    <div style="margin-bottom:4px;">
                        @foreach ($seatsInRow as $seat)
                            <button type="button"
                                    class="seat {{ $seat->is_booked ? 'booked' : '' }}"
                                    data-seat-id="{{ $seat->id }}"
                                    data-price="{{ $showtime->price }}"
                                    {{ $seat->is_booked ? 'disabled' : '' }}>
                                {{ $seat->seat_code }}
                            </button>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <div style="display:flex; gap:16px; justify-content:center; font-size:12.5px; color:var(--abu); margin-bottom:20px;">
                <span><span class="seat" style="width:16px;height:16px;display:inline-flex;margin:0 4px 0 0;"></span> Kosong</span>
                <span><span class="seat selected" style="width:16px;height:16px;display:inline-flex;margin:0 4px 0 0;"></span> Dipilih</span>
                <span><span class="seat booked" style="width:16px;height:16px;display:inline-flex;margin:0 4px 0 0;"></span> Terisi</span>
            </div>

            <div class="panel">
                <div class="field" style="margin-bottom:12px;">
                    <label for="customer_name" style="display:block; font-size:13px; color:var(--abu); margin-bottom:6px;">Nama Pemesan</label>
                    <input id="customer_name" name="customer_name" type="text" value="{{ old('customer_name', auth()->user()->name) }}" required
                           style="width:100%; background:var(--hitam-soft); border:1px solid #2c2c2c; color:var(--putih); padding:10px 12px; border-radius:8px;">
                </div>
                <div class="field" style="margin-bottom:16px;">
                    <label for="customer_email" style="display:block; font-size:13px; color:var(--abu); margin-bottom:6px;">Email</label>
                    <input id="customer_email" name="customer_email" type="email" value="{{ old('customer_email', auth()->user()->email) }}" required
                           style="width:100%; background:var(--hitam-soft); border:1px solid #2c2c2c; color:var(--putih); padding:10px 12px; border-radius:8px;">
                </div>

                <div id="summaryBox" style="border-top:1px solid #2a2a2a; padding-top:12px; margin-bottom:14px; font-size:13.5px;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                        <span class="section-sub">Kursi dipilih</span>
                        <span id="seatList">-</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                        <span class="section-sub">Rincian</span>
                        <span id="breakdown">0 kursi</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-weight:700; font-size:15px; margin-top:6px;">
                        <span>Total Bayar</span>
                        <span>Rp <span id="totalPrice">0</span></span>
                    </div>
                </div>

                <button type="submit" class="btn-merah" style="width:100%;" id="submitBtn" disabled>Lanjut Bayar</button>
            </div>
        </form>
    </div>

    <script>
        const selectedSeats = new Map(); // seatId -> { code, price }

        document.querySelectorAll('.seat[data-seat-id]:not([disabled])').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id = btn.dataset.seatId;
                const price = parseInt(btn.dataset.price);
                const code = btn.textContent.trim();

                if (selectedSeats.has(id)) {
                    selectedSeats.delete(id);
                    btn.classList.remove('selected');
                } else {
                    selectedSeats.set(id, { code: code, price: price });
                    btn.classList.add('selected');
                }

                updateSummary();
            });
        });

        function updateSummary() {
            const count = selectedSeats.size;
            let total = 0;
            let pricePerSeat = 0;
            const codes = [];

            selectedSeats.forEach(function (seat) {
                total += seat.price;
                pricePerSeat = seat.price;
                codes.push(seat.code);
            });

            document.getElementById('seatList').textContent = count > 0 ? codes.join(', ') : '-';
            document.getElementById('breakdown').textContent = count > 0
                ? count + ' kursi x Rp' + pricePerSeat.toLocaleString('id-ID')
                : '0 kursi';
            document.getElementById('totalPrice').textContent = total.toLocaleString('id-ID');
            document.getElementById('submitBtn').disabled = count === 0;

            const container = document.getElementById('hiddenSeatInputs');
            container.innerHTML = '';
            selectedSeats.forEach(function (seat, id) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'seat_ids[]';
                input.value = id;
                container.appendChild(input);
            });
        }
    </script>

@endsection
