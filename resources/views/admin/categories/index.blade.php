@extends('admin.layout')

@section('title', 'Kategori Menu')

@section('content')
    <h1>Kategori Menu</h1>
    <p><a href="{{ route('admin.categories.create', $currentMicrosite) }}">+ Tambah kategori</a></p>

    <table>
        <thead>
            <tr>
                <th>Urutan</th>
                <th>Nama</th>
                <th>Jumlah menu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->sort_order }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->menu_items_count }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', [$currentMicrosite, $category]) }}">Ubah</a>
                        <form class="inline" method="POST"
                            action="{{ route('admin.categories.destroy', [$currentMicrosite, $category]) }}"
                            onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
