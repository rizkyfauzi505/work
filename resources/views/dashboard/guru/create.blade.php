@extends('layouts.dashboard')

@section('content')

<div class="topbar">
  <button id="menuToggle" class="menu-toggle"><i class="fas fa-bars"></i></button>
  Tambah Guru
</div>

<div class="form-wrapper">
  <div class="card-form">
    <h2 style="margin-top: 0; text-align: center;">Form Tambah Guru</h2>

    @if($errors->any())
      <ul class="alert alert-danger">
        @foreach ($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    @endif

    <form id="formTambahGuru" action="{{ route('guru.store') }}" method="POST">
      @csrf
      <div class="input-group">
        <label for="nip">NIP</label>
        <input type="text" name="nip" id="nip" required>
      </div>
      <div class="input-group">
        <label for="nama_guru">Nama</label>
        <input type="text" name="nama_guru" id="nama_guru" required>
      </div>
      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
      </div>
      <div style="text-align: center; margin-top: 20px;">
        <button type="submit" id="btnSubmit" class="btn-simpan">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  const form = document.getElementById('formTambahGuru');
  const btn = document.getElementById('btnSubmit');

  btn.addEventListener('click', function (e) {
    e.preventDefault();
    Swal.fire({
      title: 'Yakin ingin simpan data?',
      text: "Pastikan data sudah benar.",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#aaa',
      confirmButtonText: 'Ya, Simpan',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  });
</script>

@if(session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '{{ session("success") }}',
      confirmButtonText: 'Oke',
      timer: 2000
    });
  </script>
@endif

@endsection
