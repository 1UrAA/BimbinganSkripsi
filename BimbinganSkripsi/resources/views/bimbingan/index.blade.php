@extends('layout')

@section('content')
<form action="/bimbingan/upload" method="POST" enctype="multipart/form-data">
@csrf
<input type="file" name="file">
<button>Upload</button>
</form>

@foreach($data as $d)
<p>{{ $d->file }} - {{ $d->status }}</p>

<form action="/bimbingan/review/{{ $d->id }}" method="POST">
@csrf
<input type="text" name="komentar" placeholder="Komentar">
<select name="status">
<option value="revisi">Revisi</option>
<option value="acc">ACC</option>
</select>
<button>Submit</button>
</form>

@endforeach
@endsection