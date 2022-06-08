@extends('mahasiswas.layout')

@section('content')
    <div class="container mt-3">
        <h3 class="text-center mb-3">JURUSAN TEKNOLOGI INFORMASI - POLITEKNIK NEGERI MALANG</h3>
        <h2 class="text-center mb-4">KARTU HASIL STUDI (KHS)</h2>

        {{-- @foreach ($MahasiswaMatakuliah as $mhs_mk) --}}
        <table class="table-borderless mt-5">
            <tr>
                <th>Nama</th>
                <th class="text-center text-bold">:</th>
                <td>{{ $mhsMatkul->nama }}</td>
            </tr>
            <tr>
                <th>NIM</th>
                <th class="text-center text-bold">:</th>
                <td>{{ $mhsMatkul->nim }}</td>
            </tr>
            <tr>
                <th>Kelas</th>
                <th class="text-center text-bold">:</th>
                <td>{{ $mhsMatkul->kelas->nama_kelas }}</td>
            </tr>
        </table>
        {{-- @endforeach --}}

        <table class="mt-4 table table-bordered table-striped table-hover">
            <thead>
                <tr class="text-center text-bold">
                    <th class="text-bold">Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Semester</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            @foreach ($MhsMatkul as $points)
                <tr class="text-center">
                <td>{{ $points->nama_matkul }}</td>
                <td>{{ $points->sks }}</td>
                <td>{{ $points->semester }}</td>
                <td>{{ $points['nilai'] }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
