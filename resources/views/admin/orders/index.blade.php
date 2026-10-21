@extends('admin.layout')

@section('title', 'Daftar Pesanan - ' . $currentMicrosite->name)

@section('content')
    <div class="card mb-6 p-4">
        <form method="GET" action="{{ route('admin.orders.index', $currentMicrosite) }}"
            class="flex flex-wrap items-end gap-3">
            <div>
                <label class="form-label" for="status">Status</label>
                <select class="input-field w-56" name="status" id="status">
                    <option value="">-- Semua Status --</option>
                    @foreach ($statuses as $st)
                        <option value="{{ $st }}" @selected($filterStatus === $st)>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label" for="date">Tanggal</label>
                <input class="input-field w-56" type="date" name="date" id="date" value="{{ $filterDate }}">
            </div>

            <div class="flex items-center gap-3">
                <button class="btn btn-primary px-5 py-3.5 text-sm" type="submit">Filter</button>
                @if ($filterStatus || $filterDate)
                    <a class="text-sm font-medium text-brand-500 hover:text-brand-600 dark:text-brand-400"
                        href="{{ route('admin.orders.index', $currentMicrosite) }}">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <div class="table-wrap">
        <table class="w-full">
            <thead class="border-b border-gray-200 dark:border-gray-800">
                <tr>
                    <th class="table-head">Waktu</th>
                    <th class="table-head">Kode</th>
                    <th class="table-head">Pelanggan</th>
                    <th class="table-head">Meja / Telp</th>
                    <th class="table-head">Total</th>
                    <th class="table-head">Status</th>
                    <th class="table-head">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($orders as $order)
                    <tr>
                        <td class="table-cell">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="table-cell font-medium text-gray-800 dark:text-white/90">{{ $order->order_code }}
                        </td>
                        <td class="table-cell">{{ $order->customer_name }}</td>
                        <td class="table-cell">
                            @if ($order->table_number)
                                Meja {{ $order->table_number }}
                            @elseif ($order->customer_phone)
                                {{ $order->customer_phone }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="table-cell">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="table-cell">
                            @php($statusClass = ['baru' => 'badge-info', 'diproses' => 'badge-warning', 'siap' => 'badge-success', 'selesai' => 'badge-neutral', 'dibatalkan' => 'badge-error'][$order->status] ?? 'badge-neutral')
                            <span class="badge {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="table-cell">
                            <a class="btn btn-outline px-4 py-3 text-sm"
                                href="{{ route('admin.orders.show', [$currentMicrosite, $order]) }}">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-cell">Belum ada pesanan yang sesuai filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
@endsection
