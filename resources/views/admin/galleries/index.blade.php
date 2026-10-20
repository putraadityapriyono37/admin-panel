@extends('admin.layout')

@section('title', 'Galeri')

@section('content')
    <h1>Galeri</h1>
    <p><a href="{{ route('admin.galleries.create', $currentMicrosite) }}">+ Tambah foto</a></p>

    <table>
        <thead>
            <tr>
                <th>Foto</th>
                <th>Caption</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($galleries as $gallery)
                <tr>
                    <td><img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->caption }}" width="120"></td>
                    <td>{{ $gallery->caption }}</td>
                    <td>
                        <a href="{{ route('admin.galleries.edit', [$currentMicrosite, $gallery]) }}">Ubah</a>
                        <form class="inline" method="POST"
                            action="{{ route('admin.galleries.destroy', [$currentMicrosite, $gallery]) }}"
                            onsubmit="return confirm('Hapus foto ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Belum ada foto.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
