@extends('admin.layout')

@section('title', 'Dashboard Super Admin')

@section('content')
    <div class="table-wrap">
        <table class="w-full">
            <thead class="border-b border-gray-200 dark:border-gray-800">
                <tr>
                    <th class="table-head">Microsite</th>
                    <th class="table-head">Status</th>
                    <th class="table-head">Lihat dashboard</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($microsites as $microsite)
                    <tr>
                        <td class="table-cell">{{ $microsite->name }}</td>
                        <td class="table-cell">
                            <span class="badge {{ $microsite->is_active ? 'badge-success' : 'badge-neutral' }}">
                                {{ $microsite->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="table-cell">
                            <a class="text-brand-500 hover:text-brand-600 dark:text-brand-400"
                                href="{{ route('admin.dashboard', $microsite) }}">Buka</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty-cell">Belum ada microsite. Tambahkan lewat menu Microsite.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
