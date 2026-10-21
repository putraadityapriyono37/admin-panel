@extends('admin.layout')

@section('title', 'Detail Pesanan ' . $order->order_code . ' - ' . $currentMicrosite->name)

@section('content')
    <p class="mb-4">
        <a class="text-sm font-medium text-brand-500 hover:text-brand-600 dark:text-brand-400"
            href="{{ route('admin.orders.index', $currentMicrosite) }}">&larr; Kembali ke Daftar Pesanan</a>
    </p>

    <div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="card p-6">
            <h2 class="text-base font-medium text-gray-800 dark:text-white/90">Informasi Pemesan</h2>
            <dl class="mt-4 space-y-2 text-sm">
                <div class="flex gap-2">
                    <dt class="w-36 font-medium text-gray-500 dark:text-gray-400">Nama</dt>
                    <dd class="text-gray-800 dark:text-white/90">{{ $order->customer_name }}</dd>
                </div>
                <div class="flex gap-2">
                    <dt class="w-36 font-medium text-gray-500 dark:text-gray-400">Nomor Meja</dt>
                    <dd class="text-gray-800 dark:text-white/90">{{ $order->table_number ?? '-' }}</dd>
                </div>
                <div class="flex gap-2">
                    <dt class="w-36 font-medium text-gray-500 dark:text-gray-400">Nomor Telepon</dt>
                    <dd class="text-gray-800 dark:text-white/90">{{ $order->customer_phone ?? '-' }}</dd>
                </div>
                <div class="flex gap-2">
                    <dt class="w-36 font-medium text-gray-500 dark:text-gray-400">Waktu Pesan</dt>
                    <dd class="text-gray-800 dark:text-white/90">{{ $order->created_at->format('d/m/Y H:i:s') }}</dd>
                </div>
                <div class="flex gap-2">
                    <dt class="w-36 font-medium text-gray-500 dark:text-gray-400">Catatan</dt>
                    <dd class="text-gray-800 dark:text-white/90">{{ $order->notes ?: '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="card p-6">
            <h2 class="text-base font-medium text-gray-800 dark:text-white/90">Status Pesanan</h2>
            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                Status saat ini:
                @php($statusClass = ['baru' => 'badge-info', 'diproses' => 'badge-warning', 'siap' => 'badge-success', 'selesai' => 'badge-neutral', 'dibatalkan' => 'badge-error'][$order->status] ?? 'badge-neutral')
                <span class="badge {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
            </p>

            <form method="POST" action="{{ route('admin.orders.status', [$currentMicrosite, $order]) }}">
                @csrf
                @method('PATCH')
                <div class="mt-4">
                    <label class="form-label" for="status">Ubah Status</label>
                    <select class="input-field" name="status" id="status" required>
                        @foreach ($statuses as $st)
                            <option value="{{ $st }}" @selected($order->status === $st)>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-4">
                    <button class="btn btn-primary px-5 py-3.5 text-sm" type="submit">Simpan Status</button>
                </div>
            </form>
        </div>
    </div>

    <h2 class="text-base font-medium text-gray-800 dark:text-white/90">Rincian Menu</h2>
    <div class="table-wrap mt-4">
        <table class="w-full">
            <thead class="border-b border-gray-200 dark:border-gray-800">
                <tr>
                    <th class="table-head">No</th>
                    <th class="table-head">Menu</th>
                    <th class="table-head">Harga Satuan</th>
                    <th class="table-head">Jumlah</th>
                    <th class="table-head">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($order->items as $index => $item)
                    <tr>
                        <td class="table-cell">{{ $index + 1 }}</td>
                        <td class="table-cell">{{ $item->item_name }}</td>
                        <td class="table-cell">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                        <td class="table-cell">{{ $item->quantity }}</td>
                        <td class="table-cell">Rp {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-cell">Tidak ada item menu dalam pesanan ini.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot class="border-t border-gray-200 dark:border-gray-800">
                <tr>
                    <td class="table-cell text-end font-medium text-gray-800 dark:text-white/90" colspan="4">
                        Total Pembayaran:</td>
                    <td class="table-cell font-medium text-gray-800 dark:text-white/90">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
