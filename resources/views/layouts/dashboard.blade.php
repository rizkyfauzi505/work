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
      src="{{ $admin->foto ? asset('storage/'.$admin->foto) : 'https://randomuser.me/api/portraits/men/75.jpg' }}"
      alt="Foto Admin" class="profile-pic">

    <p>{{ $admin->nama_admin }}</p>
    <hr>

    <!-- Menu Dashboard -->
    <a href="{{ route('dashboard.admin') }}" class="{{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
      <i class="fas fa-chart-line"></i> Dashboard
    </a>

    <!-- Menu Barang -->
    <div class="menu-item has-submenu {{ request()->is('admin/barang*') ? 'active' : '' }}">
      <a href="#" class="menu-toggle">
        <i class="fas fa-box"></i> Permintaan
        <i class="fas fa-chevron-down submenu-icon"></i>
      </a>
      <div class="submenu">
        <a href="{{ route('barang.create') }}" class="{{ request()->routeIs('barang.create') ? 'active' : '' }}">Tambah Permintaan</a>
        <a href="{{ route('barang.baru') }}" class="{{ request()->routeIs('barang.baru') ? 'active' : '' }}">Status</a>
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
    const menuToggle = document.getElementById('menuToggle');
    const body = document.getElementById('body');
    menuToggle?.addEventListener('click', () => body.classList.toggle('sidebar-collapsed'));

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

    // ✅ Klik Foto Profil → Popup
    document.getElementById('profileImageSidebar')?.addEventListener('click', function() {
      const fotoUrl = "{{ $admin->foto ? asset('storage/'.$admin->foto) : 'https://randomuser.me/api/portraits/men/75.jpg' }}";
      const nama = "{{ $admin->nama_admin }}";
      const passwordSekarang = "{{ $admin->password_plain ?? '••••••••' }}";

      function showProfilePopup() {
        Swal.fire({
          title: 'Profil Admin',
          html: `
            <style>
              .profile-popup { text-align: center; position: relative; }
              .profile-img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #3085d6; cursor: pointer; }
              .profile-name { font-size: 16px; font-weight: bold; margin-top: 10px; }
              .profile-pass { font-size: 14px; margin-top: 5px; display: inline-flex; align-items: center; gap: 5px; justify-content: center; }
              .edit-icon { position: absolute; top: 15px; right: 15px; font-size: 18px; color: #3085d6; cursor: pointer; }
              .toggle-password { cursor: pointer; color: gray; }
            </style>
            <div class="profile-popup">
              <i id="editProfileIcon" class="fas fa-edit edit-icon" title="Edit Profil"></i>
              <img id="zoomProfileImage" src="${fotoUrl}" class="profile-img" alt="Foto Profil" />
              <div class="profile-name">${nama}</div>
              <div class="profile-pass">
                <span id="passwordDisplay">••••••••</span>
                <i id="togglePasswordMain" class="fas fa-eye toggle-password"></i>
              </div>
            </div>
          `,
          showConfirmButton: false,
          width: 350,
          didOpen: () => {
            // Zoom foto
            document.getElementById('zoomProfileImage').addEventListener('click', () => {
              Swal.fire({
                imageUrl: fotoUrl,
                imageAlt: 'Foto Profil',
                showCloseButton: true,
                showConfirmButton: false,
                width: 'auto',
                background: '#000',
                backdrop: `rgba(0,0,0,0.9)`
              }).then(() => { showProfilePopup(); });
            });

            // Toggle password
            const toggleMain = document.getElementById('togglePasswordMain');
            const passDisplay = document.getElementById('passwordDisplay');
            let visible = false;
            toggleMain.addEventListener('click', () => {
              visible = !visible;
              passDisplay.textContent = visible ? passwordSekarang : '••••••••';
              toggleMain.classList.toggle('fa-eye', !visible);
              toggleMain.classList.toggle('fa-eye-slash', visible);
            });

            // Edit profil
            document.getElementById('editProfileIcon').addEventListener('click', () => {
              Swal.fire({
                title: 'Edit Profil',
                html: `
                  <style>
                    .underline-input { width: 100%; padding: 8px 0; margin: 10px 0; border: none; border-bottom: 2px solid #ccc; outline: none; font-size: 14px; background: transparent; }
                    .underline-input:focus { border-bottom-color: #3085d6; }
                    .password-wrapper { position: relative; }
                    .toggle-password { position: absolute; right: 0; top: 50%; transform: translateY(-50%); cursor: pointer; color: gray; }
                  </style>
                  <form id="editProfileForm" enctype="multipart/form-data" method="POST" action="{{ route('admin.updateProfil') }}">
                    @csrf
                    <input type="text" name="nama_admin" class="underline-input" placeholder="Nama" value="${nama}" required>
                    <div class="password-wrapper">
                      <input type="password" id="passwordField" name="password" class="underline-input" placeholder="Password baru">
                      <i id="togglePassword" class="fas fa-eye toggle-password"></i>
                    </div>
                    <input type="file" name="foto" class="underline-input" style="border:none;">
                    <button type="submit" class="swal2-confirm swal2-styled" style="margin-top:15px;padding:8px 20px;">Simpan</button>
                  </form>
                `,
                showConfirmButton: false,
                width: 350,
                didOpen: () => {
                  const togglePassword = document.getElementById('togglePassword');
                  const passwordField = document.getElementById('passwordField');
                  togglePassword.addEventListener('click', () => {
                    const isPassword = passwordField.type === "password";
                    passwordField.type = isPassword ? "text" : "password";
                    togglePassword.classList.toggle('fa-eye', !isPassword);
                    togglePassword.classList.toggle('fa-eye-slash', isPassword);
                  });

                  // Konfirmasi sebelum submit
                  document.getElementById('editProfileForm').addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                      title: 'Yakin ingin menyimpan perubahan?',
                      icon: 'question',
                      showCancelButton: true,
                      confirmButtonText: 'Ya, Simpan!',
                      cancelButtonText: 'Batal'
                    }).then((result) => {
                      if (result.isConfirmed) {
                        e.target.submit();
                      }
                    });
                  });
                }
              });
            });
          }
        });
      }
      showProfilePopup();
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
