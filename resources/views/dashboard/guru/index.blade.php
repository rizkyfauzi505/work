@extends('layouts.dashboard')

@section('content')

<div class="topbar">
  <button id="menuToggle" class="menu-toggle"><i class="fas fa-bars"></i></button>
  Daftar Guru
</div>

<div class="main-content">
  <h2>Daftar Guru</h2>

  <table border="1" cellpadding="8">
    <thead>
      <tr>
        <th>No</th>
        <th>NIP</th>
        <th>Nama Guru</th>
        <th>Password</th>
        <th style="text-align: center;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($guru as $index => $g)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $g->nip }}</td>
        <td>{{ $g->nama_guru }}</td>
        <td>{{ $g->password_plain }}</td>
        <td style="text-align: center;">
          <form action="{{ route('guru.destroy', $g->id_guru) }}" method="POST" class="form-hapus">
            @csrf
            @method('DELETE')
            <button type="button" class="btn-hapus" style="background: none; border: none; cursor: pointer;" title="Hapus">
              <i class="fas fa-trash" style="color: red;"></i>
            </button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<!-- ✅ SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // Konfirmasi hapus dengan SweetAlert
  const hapusButtons = document.querySelectorAll('.btn-hapus');
  hapusButtons.forEach((btn) => {
    btn.addEventListener('click', function () {
      const form = this.closest('form');
      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data guru akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });
  </script>



  @if(session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '{{ session("success") }}',
      showConfirmButton: false,
      timer: 2000
    });
</script>    
  @endif


@endsection
