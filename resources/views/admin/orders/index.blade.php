@extends('admin.layout')

@section('title', 'Daftar Pesanan - ' . $currentMicrosite->name)

@section('content')
    <h1>Daftar Pesanan</h1>

    <div class="filter-bar">
        <form method="GET" action="{{ route('admin.orders.index', $currentMicrosite) }}" class="filter-form">
            <div class="field">
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="">-- Semua Status --</option>
                    @foreach ($statuses as $st)
                        <option value="{{ $st }}" @selected($filterStatus === $st)>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="date">Tanggal:</label>
                <input type="date" name="date" id="date" value="{{ $filterDate }}">
            </div>

            <div class="form-actions tight">
                <button class="btn btn-secondary" type="submit">Filter</button>
                @if ($filterStatus || $filterDate)
                    <a href="{{ route('admin.orders.index', $currentMicrosite) }}">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <div class="table-scroll">
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
                            @php($statusClass = ['baru' => 'badge-info', 'diproses' => 'badge-warn', 'siap' => 'badge-teal', 'selesai' => 'badge-ok', 'dibatalkan' => 'badge-danger'][$order->status] ?? 'badge-off')
                            <span class="badge {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td>
                            <a class="btn btn-secondary btn-sm" href="{{ route('admin.orders.show', [$currentMicrosite, $order]) }}">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty">Belum ada pesanan yang sesuai filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $orders->links() }}
@endsection
