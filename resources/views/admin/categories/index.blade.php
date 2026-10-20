@extends('admin.layout')

@section('title', 'Kategori Menu')

@section('content')
    <div class="page-head">
        <h1>Kategori Menu</h1>
        <a class="btn btn-primary" href="{{ route('admin.categories.create', $currentMicrosite) }}">+ Tambah kategori</a>
    </div>

    <div class="table-scroll">
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
                            <a class="btn btn-secondary btn-sm" href="{{ route('admin.categories.edit', [$currentMicrosite, $category]) }}">Ubah</a>
                            <form class="inline" method="POST"
                                action="{{ route('admin.categories.destroy', [$currentMicrosite, $category]) }}"
                                onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty">Belum ada kategori. Tambahkan kategori sebelum menambah menu.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
