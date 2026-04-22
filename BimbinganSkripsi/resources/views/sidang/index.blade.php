@extends('layout')

@section('content')
<h3>Sidang</h3>

<form action="/sidang/daftar" method="POST">
@csrf
<input type="text" name="judul" class="form-control" placeholder="Judul">
<button class="btn btn-success mt-2">Daftar</button>
</form>

<table class="table mt-3">
<tr>
<th>Judul</th>
<th>Tanggal</th>
<th>Ruangan</th>
<th>Status</th>
<th>Nilai</th>
</tr>
@foreach($sidang as $s)
<tr>
<td>{{ $s->judul }}</td>
<td>{{ $s->tanggal }}</td>
<td>{{ $s->ruangan->nama_ruangan ?? '-' }}</td>
<td>{{ $s->status }}</td>
<td>
<form action="/nilai" method="POST" class="d-inline">
@csrf
<input type="hidden" name="sidang_id" value="{{ $s->id }}">
<input type="number" name="nilai" placeholder="Nilai" class="form-control form-control-sm d-inline-block w-auto">
<input type="text" name="catatan" placeholder="Catatan" class="form-control form-control-sm d-inline-block w-auto">
<select name="status" class="form-select form-select-sm d-inline-block w-auto">
    <option value="lulus">Lulus</option>
    <option value="revisi">Revisi</option>
</select>
<button class="btn btn-primary btn-sm">Simpan Nilai</button>
</form>
</td>
</tr>
@endforeach
</table>
@endsection