@extends('layouts.app')

@section('content')
    <style>
        /* Variabel Warna dari Layout Utama */
        :root {
            --base-color: #f0f0f3;
            --accent-color: #008cba;
            --shadow-light: #ffffff;
            --shadow-dark: #d9d9dc;
            --text-color: #4a4a4a;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --secondary-color: #95a5a6;
        }

        /* Style Judul */
        .pos-header h3 {
            font-weight: 700;
            color: var(--accent-color);
            margin-bottom: 0;
        }

        .pos-header a {
            border-radius: 12px;
        }

        /* --- List Menu Card (Item Button) --- */
        .menu-item-card {
            background-color: var(--base-color);
            border-radius: 15px;
            padding: 10px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow:
                5px 5px 10px var(--shadow-dark),
                -5px -5px 10px var(--shadow-light);
        }

        .menu-item-card:hover {
            box-shadow:
                3px 3px 6px var(--shadow-dark),
                -3px -3px 6px var(--shadow-light);
        }

        .menu-item-card:active {
            box-shadow: inset 2px 2px 5px var(--shadow-dark),
                inset -2px -2px 5px var(--shadow-light);
            transform: scale(0.98);
        }

        .menu-item-card img {
            border-radius: 10px;
        }

        .menu-item-card h6 {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0;
            font-size: 1rem;
            line-height: 1.2;
        }

        .menu-item-card p {
            font-weight: 500;
            color: var(--success-color);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .menu-item-card .add-btn {
            display: none;
            /* Hilangkan tombol Tambah, jadikan card sebagai tombol */
        }

        /* --- Keranjang (Cart) --- */
        .cart-container {
            background-color: var(--base-color);
            border-radius: 20px;
            padding: 25px;
            box-shadow:
                8px 8px 16px var(--shadow-dark),
                -8px -8px 16px var(--shadow-light);
        }

        /* Table Cart Styling */
        .table-cart {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-cart thead th {
            background-color: var(--accent-color);
            color: white;
            font-weight: 600;
            padding: 10px 15px;
            border: none;
        }

        .table-cart tbody tr td {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
        }

        .table-cart tbody tr:last-child td {
            border-bottom: none;
        }

        /* Total Section */
        .total-display {
            background-color: var(--accent-color);
            color: white;
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.4rem;
            font-weight: bold;
        }

        /* Form Controls */
        .form-control {
            border-radius: 8px;
            border: 1px solid var(--shadow-dark);
            background-color: var(--base-color);
            box-shadow: inset 2px 2px 5px var(--shadow-dark),
                inset -2px -2px 5px var(--shadow-light);
            color: var(--text-color);
            padding: 10px 15px;
        }

        /* Tombol Transaksi */
        .btn-transaction {
            border: none;
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow:
                4px 4px 8px rgba(0, 0, 0, 0.2),
                -4px -4px 8px var(--shadow-light);
        }

        .btn-success {
            background-color: var(--success-color);
            color: white;
        }

        .btn-success:hover {
            background-color: #27ae60;
        }

        .btn-danger-sm {
            border-radius: 8px;
            padding: 5px 10px;
            font-size: 0.8rem;
        }
    </style>

    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4 pos-header">
            <h3><i class="fas fa-hand-holding-usd me-2"></i> Transaksi Kasir</h3>

            <a href="{{ route('kasir.transaksi.riwayat') }}" class="btn btn-secondary btn-transaction">
                <i class="fas fa-history me-1"></i> Riwayat Transaksi
            </a>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <h5 class="fw-bold mb-3 text-secondary"><i class="fas fa-concierge-bell me-1"></i> Pilih Menu</h5>

                <div class="row g-3" style="max-height: 70vh; overflow-y: auto;">
                    @forelse($menus as $menu)
                        <div class="col-6">
                            {{-- Ganti card biasa menjadi tombol Neumorphism --}}
                            <div class="menu-item-card"
                                onclick="addItem({{ $menu->id }}, '{{ $menu->nama }}', {{ $menu->harga }})">

                                {{-- FOTO MENU --}}
                                @if ($menu->gambar)
                                    <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama }}"
                                        class="img-fluid mb-2" style="height: 120px; width: 100%; object-fit: cover;">
                                @else
                                    <div style="height: 120px; width: 100%; background-color: #eee; border-radius: 10px; display: flex; align-items: center; justify-content: center;"
                                        class="mb-2 text-muted">
                                        <i class="fas fa-image fa-2x"></i>
                                    </div>
                                @endif

                                <h6 class="mt-1">{{ $menu->nama }}</h6>
                                <p class="mb-1">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                {{-- Tombol 'Tambah' dihilangkan karena card itu sendiri adalah tombol --}}
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning text-center">
                                <i class="fas fa-exclamation-triangle"></i> Belum ada menu tersedia.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="col-md-6">
                <h5 class="fw-bold mb-3 text-secondary"><i class="fas fa-shopping-cart me-1"></i> Keranjang</h5>

                <div class="cart-container">
                    <form action="{{ route('kasir.transaksi.store') }}" method="POST">
                        @csrf

                        {{-- Tabel Keranjang --}}
                        <div class="table-responsive">
                            <table class="table table-cart table-hover align-middle text-center" id="table-cart">
                                <thead>
                                    <tr>
                                        <th class="text-start">Menu</th>
                                        <th width="80">Qty</th>
                                        <th width="120" class="text-end">Subtotal</th>
                                        <th width="50">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Keranjang kosong.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Total Display --}}
                        <div class="total-display">
                            <span>TOTAL</span>
                            <span>Rp <span id="total">0</span></span>
                        </div>
                        <input type="hidden" name="total_harga" id="total_harga" value="0">

                        {{-- Pembayaran --}}
                        <div class="mt-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Bayar</label>
                                <input type="number" class="form-control form-control-lg" id="bayar" name="bayar"
                                    required min="0" placeholder="Masukkan jumlah pembayaran">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Kembalian</label>
                                <input type="text" class="form-control form-control-lg bg-light fw-bold" id="kembalian"
                                    readonly value="Rp 0">
                                <input type="hidden" name="kembalian_raw" id="kembalian_raw">
                            </div>
                        </div>

                        <input type="hidden" name="items" id="itemsInput">

                        <button class="btn btn-transaction btn-success mt-3 w-100" type="submit">
                            <i class="fas fa-money-check-alt me-1"></i> Simpan Transaksi
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        let cart = [];

        function addItem(id, nama, harga) {
            let exists = cart.find(i => i.id === id);

            if (exists) {
                exists.qty++;
                exists.subtotal = exists.qty * harga;
            } else {
                cart.push({
                    id: id,
                    nama: nama,
                    harga: harga,
                    qty: 1,
                    subtotal: harga
                });
            }

            renderTable();
        }

        function removeItem(id) {
            cart = cart.filter(i => i.id !== id);
            renderTable();
        }

        function formatRupiah(number) {
            return number.toLocaleString('id-ID');
        }

        function calculateKembalian() {
            const total = parseInt(document.getElementById('total_harga').value || 0);
            const bayar = parseInt(document.getElementById('bayar').value) || 0;
            const kembalian = bayar - total;

            document.getElementById('kembalian_raw').value = kembalian;
            document.getElementById('kembalian').value = `Rp ${formatRupiah(kembalian)}`;
        }

        function renderTable() {
            let tbody = '';

            if (cart.length === 0) {
                tbody = `<tr><td colspan="4" class="text-center text-muted">Keranjang kosong.</td></tr>`;
            } else {
                cart.forEach(item => {
                    tbody += `
                    <tr>
                        <td class="text-start fw-bold">${item.nama}</td>
                        <td>${item.qty}</td>
                        <td class="text-end">Rp ${formatRupiah(item.subtotal)}</td>
                        <td>
                            <button class="btn btn-danger btn-sm btn-danger-sm" type="button" onclick="removeItem(${item.id})">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>
                `;
                });
            }

            document.querySelector('#table-cart tbody').innerHTML = tbody;

            let total = cart.reduce((a, b) => a + b.subtotal, 0);
            document.getElementById('total').innerHTML = formatRupiah(total);
            document.getElementById('total_harga').value = total;

            document.getElementById('itemsInput').value = JSON.stringify(cart);

            // Recalculate change after cart update
            calculateKembalian();
        }

        // Attach listener for payment input
        document.getElementById('bayar').addEventListener('input', calculateKembalian);

        // Initial render
        document.addEventListener('DOMContentLoaded', renderTable);
    </script>
@endsection
