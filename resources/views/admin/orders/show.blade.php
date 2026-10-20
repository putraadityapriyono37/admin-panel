@extends('admin.layout')

@section('title', 'Detail Pesanan ' . $order->order_code . ' - ' . $currentMicrosite->name)

@section('content')
    <p>
        <a href="{{ route('admin.orders.index', $currentMicrosite) }}">&larr; Kembali ke Daftar Pesanan</a>
    </p>

    <h1>Pesanan #{{ $order->order_code }}</h1>

    <div class="grid-2">
        <div class="card">
            <h3>Informasi Pemesan</h3>
            <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
            <p><strong>Nomor Meja:</strong> {{ $order->table_number ?? '-' }}</p>
            <p><strong>Nomor Telepon:</strong> {{ $order->customer_phone ?? '-' }}</p>
            <p><strong>Waktu Pesan:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
            <p><strong>Catatan:</strong> {{ $order->notes ?: '-' }}</p>
        </div>

        <div class="card">
            <h3>Status Pesanan</h3>
            <p>
                Status saat ini:
                @php($statusClass = ['baru' => 'badge-info', 'diproses' => 'badge-warn', 'siap' => 'badge-teal', 'selesai' => 'badge-ok', 'dibatalkan' => 'badge-danger'][$order->status] ?? 'badge-off')
                <span class="badge {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
            </p>

            <form method="POST" action="{{ route('admin.orders.status', [$currentMicrosite, $order]) }}">
                @csrf
                @method('PATCH')
                <div class="field">
                    <label for="status">Ubah Status:</label>
                    <select name="status" id="status" required>
                        @foreach ($statuses as $st)
                            <option value="{{ $st }}" @selected($order->status === $st)>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-actions">
                    <button class="btn btn-primary" type="submit">Simpan Status</button>
                </div>
            </form>
        </div>
    </div>

    <h3>Rincian Menu</h3>
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Menu</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($order->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->item_name }}</td>
                        <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty">Tidak ada item menu dalam pesanan ini.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="tfoot-label">Total Pembayaran:</td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
