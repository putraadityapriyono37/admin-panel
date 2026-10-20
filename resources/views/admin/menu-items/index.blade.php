@extends('admin.layout')

@section('title', 'Menu')

@section('content')
    <div class="page-head">
        <h1>Menu</h1>
        <a class="btn btn-primary" href="{{ route('admin.menu-items.create', $currentMicrosite) }}">+ Tambah menu</a>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>
                            @if ($item->image)
                                <img class="thumb" src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                            @else
                                <span class="hint">Tanpa foto</span>
                            @endif
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $item->is_available ? 'badge-ok' : 'badge-danger' }}">
                                {{ $item->is_available ? 'Tersedia' : 'Habis' }}
                            </span>
                        </td>
                        <td>
                            <a class="btn btn-secondary btn-sm" href="{{ route('admin.menu-items.edit', [$currentMicrosite, $item]) }}">Ubah</a>

                            <form class="inline" method="POST"
                                action="{{ route('admin.menu-items.toggle', [$currentMicrosite, $item]) }}">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-secondary btn-sm"
                                    type="submit">{{ $item->is_available ? 'Tandai habis' : 'Tandai tersedia' }}</button>
                            </form>

                            <form class="inline" method="POST"
                                action="{{ route('admin.menu-items.destroy', [$currentMicrosite, $item]) }}"
                                onsubmit="return confirm('Hapus menu ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">Belum ada menu. Tambahkan menu setelah kategori tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
