@extends('admin.layout')

@section('title', 'Daftar Pesanan - ' . $currentMicrosite->name)

@section('content')
    <h1>Daftar Pesanan</h1>

    <div style="background: #f4f4f4; padding: 12px; margin-bottom: 16px; border-radius: 4px;">
        <form method="GET" action="{{ route('admin.orders.index', $currentMicrosite) }}" style="display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap;">
            <div>
                <label for="status" style="display: block; font-size: 14px; margin-bottom: 4px;">Status:</label>
                <select name="status" id="status">
                    <option value="">-- Semua Status --</option>
                    @foreach ($statuses as $st)
                        <option value="{{ $st }}" @selected($filterStatus === $st)>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="date" style="display: block; font-size: 14px; margin-bottom: 4px;">Tanggal:</label>
                <input type="date" name="date" id="date" value="{{ $filterDate }}">
            </div>

            <div>
                <button type="submit">Filter</button>
                @if ($filterStatus || $filterDate)
                    <a href="{{ route('admin.orders.index', $currentMicrosite) }}" style="margin-left: 6px;">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Kode</th>
                <th>Pelanggan</th>
                <th>Meja / Telp</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td><strong>{{ $order->order_code }}</strong></td>
                    <td>{{ $order->customer_name }}</td>
                    <td>
                        @if ($order->table_number)
                            Meja {{ $order->table_number }}
                        @elseif ($order->customer_phone)
                            {{ $order->customer_phone }}
                        @else
                            -
                        @endif
                    </td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td>
                        <span style="display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;
                            background: {{ $order->status === 'baru' ? '#e0f2fe' : ($order->status === 'diproses' ? '#fef3c7' : ($order->status === 'siap' ? '#f3e8ff' : ($order->status === 'selesai' ? '#dcfce7' : '#fee2e2'))) }};
                            color: {{ $order->status === 'baru' ? '#0369a1' : ($order->status === 'diproses' ? '#b45309' : ($order->status === 'siap' ? '#6b21a8' : ($order->status === 'selesai' ? '#15803d' : '#b91c1c'))) }};">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', [$currentMicrosite, $order]) }}">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada pesanan yang sesuai filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 16px;">
        {{ $orders->links() }}
    </div>
@endsection
