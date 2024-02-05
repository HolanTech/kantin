@extends('layouts.admin')

@section('content')
    <div class="row p-3">
        <div class="col-6 p-3">
            <div class="card p-3">
                <h1>Top-UP</h1>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form method="post" action="{{ route('admin.user.topupstore') }}">
                    @csrf
                    <div class="form-group">
                        <label for="rfidInputTopUp">Tempelkan Kartu RFID:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="rfidInputTopUp" autofocus placeholder="ID RFID"
                                required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nominalInput">Masukkan Nominal Top-UP:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="nominalInput" placeholder="Nominal" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Pilih Metode Pembayaran:</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="paymentMethod" value="cash" checked>
                            <label class="form-check-label">Cash</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="paymentMethod" value="midtrans">
                            <label class="form-check-label">Midtrans</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">TOP-UP</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-6 p-3">
            <div class="card p-3">
                <h1>Cek Saldo</h1>
                @if (session('saldo'))
                    <div class="alert alert-info">
                        Saldo Tersedia: Rp {{ session('saldo') }}
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="post" action="{{ route('admin.user.checksaldo') }}" id="checkSaldoForm">
                    @csrf
                    <div class="form-group">
                        <label for="rfidInputCheck">Tempelkan Kartu RFID:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="rfidInputCheck" autofocus placeholder="ID RFID"
                                required />
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Cek</button>
                            </div>
                        </div>
                        <small id="rfidHelp" class="form-text text-muted">Pindai kartu RFID Anda untuk mendapatkan
                            ID.</small>
                    </div>
                </form>

                <!-- Tempat untuk menampilkan saldo jika RFID terdaftar -->
                <div id="saldoContainer" style="display: none;">
                    <p id="saldoText">Saldo Tersedia: Rp <span id="saldoAmount">0</span></p>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var saldoContainer = document.getElementById('saldoContainer');
            var saldoAmount = document.getElementById('saldoAmount');
            var checkSaldoForm = document.getElementById('checkSaldoForm');

            checkSaldoForm.addEventListener('submit', function(e) {
                e.preventDefault();
                var rfid = document.getElementsByName('rfidInputCheck')[0].value;

                fetch('{{ route('admin.user.checksaldo') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            rfidInputCheck: rfid
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.saldo !== undefined) {
                            saldoContainer.style.display = 'block';
                            saldoAmount.innerText = data.saldo;
                        } else {
                            alert(data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
@endpush
