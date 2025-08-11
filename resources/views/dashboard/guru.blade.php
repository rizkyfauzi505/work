<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <style>
    body, .sidebar, .main {
      transition: all 0.4s ease-in-out;
    }
  </style>
</head>
<body id="body">
  <div class="sidebar" id="sidebar">
    <h3>Halaman Guru</h3>
    <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Foto Admin">
    <p>{{ $guru->nama_guru }}</p>

    <hr>

    <!-- ✅ Dashboard -->
<a href="{{ route('dashboard.admin') }}" class="{{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
  <i class="fas fa-chart-line"></i> Dashboard
</a>

<!-- ✅ Menu Barang -->
<!-- <div class="menu-item has-submenu {{ request()->is('admin/barang*') ? 'active' : '' }}">
  <a href="#" class="menu-toggle">
    <i class="fas fa-box"></i> Barang
    <i class="fas fa-chevron-down submenu-icon"></i>
  </a> -->
  <div class="submenu">
    <a href="{{ route('barang.create') }}" class="{{ request()->routeIs('barang.create') ? 'active' : '' }}">Tambah Barang</a>
    <a href="{{ route('barang.baru') }}" class="{{ request()->routeIs('barang.baru') ? 'active' : '' }}">Barang Baru</a>
    <a href="{{ route('barang.stok') }}" class="{{ request()->routeIs('barang.stok') ? 'active' : '' }}">All Stok</a>
  </div>
</div>




<!-- ✅ Menu Guru -->
<!-- <div class="menu-item has-submenu {{ request()->routeIs('guru.*') ? 'active' : '' }}">
  <a href="#" class="menu-toggle">
    <i class="fas fa-user"></i> Guru
    <i class="fas fa-chevron-down submenu-icon"></i>
  </a> -->
  <!-- <div class="submenu">
    <a href="{{ route('guru.create') }}">Tambah Guru</a>
    <a href="{{ route('guru.index') }}">Daftar Guru</a>
  </div>
</div> -->




    <!-- ✅ Logout dengan SweetAlert -->
    <a href="#" id="logoutButton"><i class="fas fa-sign-out-alt"></i> Logout</a>
    <form id="logoutForm" action="{{ route('logout') }}" method="GET" style="display: none;"></form>
  </div>

  <div class="main" id="main">
    <div class="topbar">
      <button id="menuToggle" class="menu-toggle"><i class="fas fa-bars"></i></button>
      Dashboard
    </div>

    <div class="search-box">
      <input type="text" placeholder="search">
    </div>

    <div class="cards">
  <a href="{{ route('barang.stok') }}" style="text-decoration: none; flex: 1;">
    <div class="card red">
      <i class="fas fa-box"></i>
      
      <!-- <div class="label">All Stok</div> -->
    </div>
  </a>

  <a href="{{ route('barang.baru') }}" style="text-decoration: none; flex: 1;">
    <div class="card blue">
      <i class="fas fa-rotate-right"></i>
      
      <div class="label">Barang Baru</div>
    </div>
  </a>

  <a href="#" style="text-decoration: none; flex: 1;">
    <div class="card green">
      <i class="fas fa-file-alt"></i>
      <div class="count">0</div>
      <div class="label">Permintaan</div>
    </div>
  </a>
</div>





  <!-- ✅ SweetAlert & Script Sidebar -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Sidebar toggle
    const menuToggle = document.getElementById('menuToggle');
    const body = document.getElementById('body');
    menuToggle.addEventListener('click', () => {
      body.classList.toggle('sidebar-collapsed');
    });

    // Submenu toggle
    const submenuToggles = document.querySelectorAll('.menu-toggle');
    submenuToggles.forEach(toggle => {
      toggle.addEventListener('click', function(e) {
        const parent = this.closest('.has-submenu');
        if (parent) {
          e.preventDefault();
          parent.classList.toggle('active');
        }
      });
    });

    // SweetAlert Logout
    document.getElementById('logoutButton').addEventListener('click', function (e) {
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
</body>
</html>
