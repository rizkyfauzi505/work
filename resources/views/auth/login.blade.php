<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
  <div class="form-box">
    <h2>Login</h2>
    @if(session('error'))
      <p class="error">{{ session('error') }}</p>
    @endif
    <form method="POST" action="{{ route('login') }}">
  @csrf
  <div class="input-group">
    
    <input type="text" name="nama" id="nama" required placeholder="Masukkan Nama">
  </div>
  <div class="input-group">
    
    <input type="password" name="password" id="password" required placeholder="Masukkan Password">
  </div>
  <div class="input-group">
    
    <select name="role" id="role" required>
      <option value="admin">Admin</option>
      <option value="guru">Guru</option>
    </select>
  </div>
  <button type="submit">Login</button>
  <p class="small-text">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
</form>

  </div>
</body>
</html>
