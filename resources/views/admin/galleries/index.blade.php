@extends('admin.layout')

@section('title', 'Galeri')

@section('content')
    <div class="page-head">
        <h1>Galeri</h1>
        <a class="btn btn-primary" href="{{ route('admin.galleries.create', $currentMicrosite) }}">+ Tambah foto</a>
    </div>

    <div class="table-scroll">
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
                        <td><img class="thumb" src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->caption }}"></td>
                        <td>{{ $gallery->caption }}</td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-secondary btn-sm" href="{{ route('admin.galleries.edit', [$currentMicrosite, $gallery]) }}">Ubah</a>
                                <form class="inline" method="POST"
                                    action="{{ route('admin.galleries.destroy', [$currentMicrosite, $gallery]) }}"
                                    onsubmit="return confirm('Hapus foto ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty">Belum ada foto. Tambahkan foto untuk mengisi galeri.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
