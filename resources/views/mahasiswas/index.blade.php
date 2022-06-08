@extends('mahasiswas.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="text-center mt-3 mb-5">
                <h2>JURUSAN TEKNOLOGI INFORMASI - POLITEKNIK NEGERI MALANG</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="text-right mb-4">
                <a class="btn btn-success" href="{{ route('mahasiswas.create') }}">
                    Input Mahasiswa
                </a>
            </div>
        <div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered mt-4 mb-5" id="list_mahasiswa">
        <thead>
        <tr class="text-center">
            <th>No</th>
            <th>NIM</th>
            {{-- <th>Email</th> --}}
            <th>Nama</th>
            <th>Foto</th>
            <th>Tanggal-Lahir</th>
            <th>Kelas</th>
            {{-- <th>Jurusan</th> --}}
            <th>No HP</th>
            <th>Action</th>
        </tr>
        </thead>
        @foreach ($Mahasiswa as $mhs)
        <tr>
            <td class="align-middle text-center">{{ $mhs->id }}</td>
            <td class="align-middle text-center">{{ $mhs->nim }}</td>
            {{-- <td class="align-middle">{{ $mhs->email }}</td> --}}
            <td class="align-middle">{{ $mhs->nama }}</td>
            <td class="align-middle">
                <img src="{{ asset('student/'.$mhs->images) }}" alt="" height="100px" width="100px">
            </td>
            <td class="align-middle">{{ $mhs->tgl_lahir }}</td>
            <td class="align-middle text-center">{{ $mhs->kelas->nama_kelas}}</td>
            {{-- <td class="align-middle">{{ $mhs->jurusan }}</td> --}}
            <td class="align-middle">{{ $mhs->no_hp }}</td>
            <td class="align-middle text-center">
                <form action="{{ route('mahasiswas.destroy', $mhs->nim )}}" method="POST" enctype="multipart/form-data">
                    <a class="btn btn-info" href="{{ route('mahasiswas.show', $mhs->nim) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('mahasiswas.edit', $mhs->nim) }}">Edit</a>
                    <a class="btn btn-warning" href="/mahasiswas/nilai/{{ $mhs->id }}">Nilai</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
@endsection
