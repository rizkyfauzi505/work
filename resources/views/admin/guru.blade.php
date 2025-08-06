@extends('layouts.dashboard')

@section('content')
<div class="form-guru">
  <h3>Tambah Guru</h3>

  @if (session('success'))
    <div style="color: green;">{{ session('success') }}</div>
  @endif

  <form action="{{ route('guru.store') }}" method="POST">
    @csrf
    <input type="text" name="nip" placeholder="NIP" required>
    <input type="text" name="nama_guru" placeholder="Nama Guru" required>
    <select name="id_user" required>
      <option value="">Pilih User</option>
      @foreach ($users as $user)
        <option value="{{ $user->id_user }}">{{ $user->username }}</option>
      @endforeach
    </select>
    <button type="submit">Tambah</button>
  </form>
</div>

<hr>

<div class="daftar-guru">
  <h3>Daftar Guru</h3>
  <table border="1" cellpadding="8" cellspacing="0">
    <thead>
      <tr>
        <th>NIP</th>
        <th>Nama</th>
        <th>Username</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($guru as $g)
      <tr>
        <td>{{ $g->nip }}</td>
        <td>{{ $g->nama_guru }}</td>
        <td>{{ $g->user->username ?? '-' }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
