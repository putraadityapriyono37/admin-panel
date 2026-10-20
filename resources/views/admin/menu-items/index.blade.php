@extends('admin.layout')

@section('title', 'Menu')

@section('content')
    <h1>Menu</h1>
    <p><a href="{{ route('admin.menu-items.create', $currentMicrosite) }}">+ Tambah menu</a></p>

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
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" width="60">
                        @endif
                    </td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ $item->is_available ? 'Tersedia' : 'Habis' }}</td>
                    <td>
                        <a href="{{ route('admin.menu-items.edit', [$currentMicrosite, $item]) }}">Ubah</a>

                        <form class="inline" method="POST"
                            action="{{ route('admin.menu-items.toggle', [$currentMicrosite, $item]) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit">{{ $item->is_available ? 'Tandai habis' : 'Tandai tersedia' }}</button>
                        </form>

                        <form class="inline" method="POST"
                            action="{{ route('admin.menu-items.destroy', [$currentMicrosite, $item]) }}"
                            onsubmit="return confirm('Hapus menu ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada menu.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
