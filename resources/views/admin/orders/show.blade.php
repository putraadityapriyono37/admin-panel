@extends('admin.layout')

@section('title', 'Detail Pesanan ' . $order->order_code . ' - ' . $currentMicrosite->name)

@section('content')
    <p>
        <a href="{{ route('admin.orders.index', $currentMicrosite) }}">&larr; Kembali ke Daftar Pesanan</a>
    </p>

    <h1>Pesanan #{{ $order->order_code }}</h1>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
        <div style="background: #fafafa; border: 1px solid #ddd; padding: 14px; border-radius: 4px;">
            <h3 style="margin-top: 0;">Informasi Pemesan</h3>
            <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
            <p><strong>Nomor Meja:</strong> {{ $order->table_number ?? '-' }}</p>
            <p><strong>Nomor Telepon:</strong> {{ $order->customer_phone ?? '-' }}</p>
            <p><strong>Waktu Pesan:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
            <p><strong>Catatan:</strong> {{ $order->notes ?: '-' }}</p>
        </div>

        <div style="background: #fafafa; border: 1px solid #ddd; padding: 14px; border-radius: 4px;">
            <h3 style="margin-top: 0;">Status Pesanan</h3>
            <p>
                Status saat ini:
                <span style="display: inline-block; padding: 3px 10px; border-radius: 4px; font-size: 13px; font-weight: bold;
                    background: {{ $order->status === 'baru' ? '#e0f2fe' : ($order->status === 'diproses' ? '#fef3c7' : ($order->status === 'siap' ? '#f3e8ff' : ($order->status === 'selesai' ? '#dcfce7' : '#fee2e2'))) }};
                    color: {{ $order->status === 'baru' ? '#0369a1' : ($order->status === 'diproses' ? '#b45309' : ($order->status === 'siap' ? '#6b21a8' : ($order->status === 'selesai' ? '#15803d' : '#b91c1c'))) }};">
                    {{ ucfirst($order->status) }}
                </span>
            </p>

            <form method="POST" action="{{ route('admin.orders.status', [$currentMicrosite, $order]) }}" style="margin-top: 14px;">
                @csrf
                @method('PATCH')
                <label for="status" style="display: block; font-weight: bold; margin-bottom: 6px;">Ubah Status:</label>
                <div style="display: flex; gap: 8px;">
                    <select name="status" id="status" required>
                        @foreach ($statuses as $st)
                            <option value="{{ $st }}" @selected($order->status === $st)>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                    <button type="submit">Simpan Status</button>
                </div>
            </form>
        </div>
    </div>

    <h3>Rincian Menu</h3>
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
                    <td colspan="5">Tidak ada item menu dalam pesanan ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="font-weight: bold; background: #f8f8f8;">
                <td colspan="4" style="text-align: right;">Total Pembayaran:</td>
                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
@endsection
