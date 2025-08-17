<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body, .sidebar, .main { transition: all 0.4s ease-in-out; }
    .profile-pic { cursor: pointer; border-radius: 50%; width: 80px; height: 80px; object-fit: cover; }
  </style>
</head>
<body id="body">

  <!-- ✅ SIDEBAR -->
  <div class="sidebar" id="sidebar">
    <h3>Halaman Admin</h3>
    <img id="profileImageSidebar"
      src="{{ isset($admin) && $admin->foto ? asset('storage/'.$admin->foto) : 'https://randomuser.me/api/portraits/men/75.jpg' }}"
      alt="Foto Admin" class="profile-pic">

    <p>{{ isset($admin) ? $admin->nama_admin : 'Admin' }}</p>
    <hr>

    <!-- Menu Dashboard -->
    <a href="{{ route('dashboard.admin') }}" class="{{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
      <i class="fas fa-chart-line"></i> Dashboard
    </a>

    <!-- ✅ Menu Barang -->
    <div class="menu-item has-submenu {{ request()->is('admin/barang*') ? 'active' : '' }}">
      <a href="#" class="menu-toggle">
        <i class="fas fa-box"></i> Barang
        <i class="fas fa-chevron-down submenu-icon"></i>
      </a>
      <div class="submenu">
        <a href="{{ route('barang.create') }}" class="{{ request()->routeIs('barang.create') ? 'active' : '' }}">Tambah Barang</a>
        <a href="{{ route('barang.baru') }}" class="{{ request()->routeIs('barang.baru') ? 'active' : '' }}">Barang Baru</a>
        <a href="{{ route('barang.stok') }}" class="{{ request()->routeIs('barang.stok') ? 'active' : '' }}">All Stok</a>
      </div>
    </div>

    <!-- Menu Permintaan -->
    <div class="menu-item has-submenu {{ request()->is('admin/permintaan*') ? 'active' : '' }}">
      <a href="#" class="menu-toggle">
        <i class="fas fa-clipboard-list"></i> Permintaan
        <i class="fas fa-chevron-down submenu-icon"></i>
      </a>
      <div class="submenu">
        <a href="{{ route('permintaan.index') }}" class="{{ request()->routeIs('permintaan.index') ? 'active' : '' }}">
          Daftar Permintaan
        </a>
      </div>
    </div>

    <!-- Menu Guru -->
    <div class="menu-item has-submenu {{ request()->is('admin/guru*') ? 'active' : '' }}">
      <a href="#" class="menu-toggle">
        <i class="fas fa-user"></i> Guru
        <i class="fas fa-chevron-down submenu-icon"></i>
      </a>
      <div class="submenu">
        <a href="{{ route('guru.create') }}" class="{{ request()->routeIs('guru.create') ? 'active' : '' }}">Tambah Guru</a>
        <a href="{{ route('guru.index') }}" class="{{ request()->is('admin/guru') ? 'active' : '' }}">Daftar Guru</a>
      </div>
    </div>

    <!-- Logout -->
    <a href="#" id="logoutButton"><i class="fas fa-sign-out-alt"></i> Logout</a>
    <form id="logoutForm" action="{{ route('logout') }}" method="GET" style="display: none;"></form>
  </div>

  <!-- ✅ MAIN CONTENT -->
  <div class="main" id="main">
    @yield('content')
  </div>

  <!-- ✅ Sidebar & Submenu Toggle -->
  <script>
    document.querySelectorAll('.menu-toggle').forEach(toggle => {
      toggle.addEventListener('click', function(e) {
        const parent = this.closest('.has-submenu');
        if (parent) {
          e.preventDefault();
          parent.classList.toggle('active');
        }
      });
    });

    // ✅ Logout SweetAlert
    document.getElementById('logoutButton')?.addEventListener('click', function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Yakin mau logout?',
        text: "Anda akan keluar dari sistem!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Logout!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('logoutForm').submit();
        }
      });
    });
  </script>

  @if(session('success'))
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#3085d6'
      });
    });
  </script>
  @endif

</body>
</html>
