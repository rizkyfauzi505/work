<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>
    .input-group {
      margin-bottom: 15px;
    }

    .error {
      color: red;
      list-style: none;
      padding-left: 0;
    }

    .hidden {
      display: none;
    }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>Register</h2>

    @if($errors->any())
      <ul class="error">
        @foreach ($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    @endif

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <!-- Input NIP (tampilkan berdasarkan role) -->
      <div class="input-group" id="nipField">
        <input type="text" name="nip" id="nip" placeholder="Masukkan NIP">
      </div>

      <div class="input-group">
        <input type="text" name="nama" required placeholder="Masukkan Nama">
      </div>

      <div class="input-group">
        <input type="password" name="password" required placeholder="Masukkan Password">
      </div>

      <div class="input-group">
        <select name="role" id="role" required onchange="toggleNipField()">
          <option value="">-- Pilih Role --</option>
          <option value="admin">Admin</option>
          <option value="guru">Guru</option>
        </select>
      </div>

      <button type="submit">Daftar</button>

      <p class="small-text">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
    </form>
  </div>

  <script>
    function toggleNipField() {
      const role = document.getElementById('role').value;
      const nipField = document.getElementById('nipField');

      // Tampilkan NIP jika role admin/guru
      if (role === 'admin' || role === 'guru') {
        nipField.style.display = 'block';
      } else {
        nipField.style.display = 'none';
      }
    }

    // Jalankan saat halaman pertama kali dimuat
    window.onload = toggleNipField;
  </script>
</body>
</html>
