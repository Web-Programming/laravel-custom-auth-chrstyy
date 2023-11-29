@extends('layout.master')
@section('title', 'Halaman List Prodi')

@section('content')
    <div class="row pt-4">
        <div class="col">
            <h2>Prodi</h2>
            <div class="d-md-flex justify-content-md-end">
                <a href="{{ route('prodi.create') }}" class="btn btn-primary">Tambah</a>
            </div>
            @if (session()->has('info'))
                <div class="alert alert-success">
                    {{ session()->get('info') }}
                </div>
            @endif
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <td>Foto</td>
                        <th>Nama Prodi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prodis as $item)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $item->foto) }}" width="100px">
                            </td>
                            <td> {{ $item->nama }}</td>
                            <td>

                                <form action="{{ route('prodi.destroy', ['prodi' => $item->id]) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <a href="{{ url('prodi/' . $item->id) }}" class="btn btn-warning">Detail</a>
                                    <a href="{{ url('prodi/' . $item->id . '/edit') }}" class="btn btn-info">Edit</a>
                                    @can('delete', $item)
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    @endcan
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
