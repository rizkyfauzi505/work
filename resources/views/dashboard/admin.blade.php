<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard Admin</title>

  <!-- FontAwesome untuk icon -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  />

  <!-- CSS Dashboard, sesuaikan pathnya -->
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />

  <style>
    /* Transisi smooth untuk sidebar dan main content */
    body,
    .sidebar,
    .main {
      transition: all 0.4s ease-in-out;
    }

    /* Styling foto profil sidebar */
    .profile-pic {
      cursor: pointer;
      border-radius: 50%;
      width: 80px;
      height: 80px;
      object-fit: cover;
    }

    /* Submenu default sembunyi */
    .menu-item .submenu {
      display: none;
      padding-left: 15px;
    }

    /* Tampilkan submenu jika menu-item active */
    .menu-item.active .submenu {
      display: block;
    }

    /* Styling link submenu */
    .submenu a {
      display: block;
      padding: 8px 0;
      color: #ffffffff;
      text-decoration: none;
      padding-left: 10px;
    }
    /* Link submenu aktif */
    .submenu a.active {
      font-weight: bold;
      color: #3085d6;
    }

    /* Styling link sidebar */
    .sidebar a {
      display: block;
      padding: 10px 15px;
      color: #ffffffff;
      text-decoration: none;
      font-weight: 600;
    }
    .sidebar a.active {
      background-color: #3085d6;
      color: white;
    }

    /* Icon panah submenu */
    .submenu-icon {
      float: right;
      transition: transform 0.3s ease;
    }
    /* Rotasi icon saat submenu aktif */
    .menu-item.active > a .submenu-icon {
      transform: rotate(180deg);
    }
  </style>
</head>
<body id="body">
  <div class="sidebar" id="sidebar">
    <h3>Halaman Admin</h3>

    <!-- Foto profil jadi tombol -->
    <img
      id="profileImageSidebar"
      src="{{ $admin->foto ? asset('storage/'.$admin->foto) : 'https://randomuser.me/api/portraits/men/75.jpg' }}"
      alt="Foto Admin"
      class="profile-pic"
    />

    <!-- Nama admin -->
    <p>{{ $admin->nama_admin }}</p>
    <hr />

    <!-- Link Dashboard -->
    <a
      href="{{ route('dashboard.admin') }}"
      class="{{ request()->routeIs('dashboard.admin') ? 'active' : '' }}"
      ><i class="fas fa-chart-line"></i> Dashboard</a
    >

    <!-- Menu Barang dengan submenu -->
    <div
      class="menu-item has-submenu {{ request()->is('admin/barang*') ? 'active' : '' }}"
    >
      <a href="#" class="menu-toggle">
        <i class="fas fa-box"></i> Barang
        <i class="fas fa-chevron-down submenu-icon"></i>
      </a>

      <!-- Submenu Barang -->
      <div class="submenu">
        <a
          href="{{ route('barang.create') }}"
          class="{{ request()->is('admin/barang/create') ? 'active' : '' }}"
          >Tambah Barang</a
        >
        <a
          href="{{ route('barang.baru') }}"
          class="{{ request()->is('admin/barang/baru') ? 'active' : '' }}"
          >Barang Baru</a
        >
        <a
          href="{{ route('barang.stok') }}"
          class="{{ request()->is('admin/barang/stok') ? 'active' : '' }}"
          >All Stok</a
        >
      </div>
    </div>

        <!-- Menu Permintaan -->
    <div class="menu-item has-submenu {{ request()->is('admin/permintaan*') ? 'active' : '' }}">
      <a href="#" class="menu-toggle">
        <i class="fas fa-clipboard-list"></i> Permintaan
        <i class="fas fa-chevron-down submenu-icon"></i>
      </a>
      <div class="submenu">
        {{-- Hanya link untuk lihat daftar permintaan --}}
        <a href="{{ route('permintaan.index') }}" class="{{ request()->routeIs('permintaan.index') ? 'active' : '' }}">
          Daftar Permintaan
        </a>
      </div>
    </div>


    <!-- Menu Guru dengan submenu -->
    <div
      class="menu-item has-submenu {{ request()->is('admin/guru*') ? 'active' : '' }}"
    >
      <a href="#" class="menu-toggle">
        <i class="fas fa-user"></i> Guru
        <i class="fas fa-chevron-down submenu-icon"></i>
      </a>

      <!-- Submenu Guru -->
      <div class="submenu">
        <a
          href="{{ route('guru.create') }}"
          class="{{ request()->is('admin/guru/create') ? 'active' : '' }}"
          >Tambah Guru</a
        >
        <a
          href="{{ route('guru.index') }}"
          class="{{ request()->is('admin/guru') ? 'active' : '' }}"
          >Daftar Guru</a
        >
      </div>
    </div>

    <!-- Logout -->
    <a href="#" id="logoutButton"
      ><i class="fas fa-sign-out-alt"></i> Logout</a
    >
    <!-- Form logout pakai POST agar aman -->
    <form
      id="logoutForm"
      action="{{ route('logout') }}"
      method="POST"
      style="display: none"
    >
      @csrf
    </form>
  </div>

  <div class="main" id="main">
    <div class="topbar">
      <button id="menuToggle" class="menu-toggle">
        <i class="fas fa-bars"></i>
      </button>
      Dashboard
    </div>

    <div class="cards">
      <a href="{{ route('barang.stok') }}" style="text-decoration: none; flex: 1">
        <div class="card red">
          <i class="fas fa-box"></i>
          <div class="count">{{ $totalStok }}</div>
          <div class="label">All Stok</div>
        </div>
      </a>

      <a href="{{ route('barang.baru') }}" style="text-decoration: none; flex: 1">
        <div class="card blue">
          <i class="fas fa-rotate-right"></i>
          <div class="count">{{ $barangBaru }}</div>
          <div class="label">Barang Baru</div>
        </div>
      </a>

      <a href="{{ route('permintaan.index') }}" style="text-decoration: none; flex: 1">
        <div class="card green">
          <i class="fas fa-file-alt"></i>
          <div class="count">0</div>
          <div class="label">Permintaan</div>
        </div>
      </a>
    </div>
  </div>

  <!-- SweetAlert untuk popup -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    // Toggle sidebar kecil/besar
    const menuToggle = document.getElementById("menuToggle");
    const body = document.getElementById("body");
    menuToggle.addEventListener("click", () => {
      body.classList.toggle("sidebar-collapsed");
    });

    // Toggle submenu saat klik menu-toggle (Barang, Guru, dll)
    const submenuToggles = document.querySelectorAll(".menu-toggle");
    submenuToggles.forEach((toggle) => {
      toggle.addEventListener("click", function (e) {
        const parent = this.closest(".has-submenu");
        if (parent) {
          e.preventDefault();
          parent.classList.toggle("active");
        }
      });
    });

    // SweetAlert Logout confirmation
    document.getElementById("logoutButton").addEventListener("click", function (e) {
      e.preventDefault();
      Swal.fire({
        title: "Yakin mau logout?",
        text: "Anda akan keluar dari sistem!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Logout!",
        cancelButtonText: "Batal",
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById("logoutForm").submit();
        }
      });
    });

    // Tombol Edit Profil + Popup Profil Admin
    document
      .getElementById("profileImageSidebar")
      .addEventListener("click", function () {
        const fotoUrl =
          "{{ $admin->foto ? asset('storage/'.$admin->foto) : 'https://randomuser.me/api/portraits/men/75.jpg' }}";
        const nama = "{{ $admin->nama_admin }}";
        const passwordSekarang = "{{ $admin->password_plain ?? '••••••••' }}";

        Swal.fire({
          title: "Profil Admin",
          html: `
          <style>
            .profile-popup {
              text-align: center;
              position: relative;
            }
            .profile-img {
              width: 100px;
              height: 100px;
              border-radius: 50%;
              object-fit: cover;
              border: 3px solid #3085d6;
              cursor: pointer;
            }
            .profile-name {
              font-size: 16px;
              font-weight: bold;
              margin-top: 10px;
            }
            .profile-pass {
              font-size: 14px;
              margin-top: 5px;
              display: inline-flex;
              align-items: center;
              gap: 5px;
              justify-content: center;
            }
            .edit-icon {
              position: absolute;
              top: 15px;
              right: 15px;
              font-size: 18px;
              color: #3085d6;
              cursor: pointer;
            }
            .toggle-password {
              cursor: pointer;
              color: gray;
            }
          </style>
          <div class="profile-popup">
            <i
              id="editProfileIcon"
              class="fas fa-edit edit-icon"
              title="Edit Profil"
            ></i>
            <img
              id="zoomProfileImage"
              src="${fotoUrl}"
              class="profile-img"
              alt="Foto Profil"
            />
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
            // Klik foto → Zoom
            document
              .getElementById("zoomProfileImage")
              .addEventListener("click", function () {
                Swal.fire({
                  imageUrl: fotoUrl,
                  imageAlt: "Foto Profil",
                  showCloseButton: true,
                  showConfirmButton: false,
                  width: "auto",
                  background: "#000",
                  backdrop: rgba(0,0,0,0.9),
                });
              });

            // Toggle password di popup utama
            const toggleMain = document.getElementById("togglePasswordMain");
            const passDisplay = document.getElementById("passwordDisplay");
            let visible = false;

            toggleMain.addEventListener("click", function () {
              visible = !visible;
              if (visible) {
                passDisplay.textContent = passwordSekarang;
                toggleMain.classList.remove("fa-eye");
                toggleMain.classList.add("fa-eye-slash");
              } else {
                passDisplay.textContent = "••••••••";
                toggleMain.classList.remove("fa-eye-slash");
                toggleMain.classList.add("fa-eye");
              }
            });

            // Klik icon edit → buka form edit profil
            document
              .getElementById("editProfileIcon")
              .addEventListener("click", function () {
                Swal.fire({
                  title: "Edit Profil",
                  html: `
                      <style>
                        .underline-input {
                          width: 100%;
                          padding: 8px 0;
                          margin: 10px 0;
                          border: none;
                          border-bottom: 2px solid #ccc;
                          outline: none;
                          font-size: 14px;
                          background: transparent;
                        }
                        .underline-input:focus {
                          border-bottom-color: #3085d6;
                        }
                        .password-wrapper {
                          position: relative;
                        }
                        .toggle-password {
                          position: absolute;
                          right: 0;
                          top: 50%;
                          transform: translateY(-50%);
                          cursor: pointer;
                          color: gray;
                        }
                      </style>
                      <form
                        id="editProfileForm"
                        enctype="multipart/form-data"
                        method="POST"
                        action="{{ route('admin.update.profil') }}"
                      >
                        @csrf
                        <input
                          type="text"
                          name="nama_admin"
                          class="underline-input"
                          placeholder="Nama"
                          value="${nama}"
                          required
                        />

                        <div class="password-wrapper">
                          <input
                            type="password"
                            id="passwordField"
                            name="password"
                            class="underline-input"
                            placeholder="Password baru"
                          />
                          <i
                            id="togglePassword"
                            class="fas fa-eye toggle-password"
                          ></i>
                        </div>

                        <input
                          type="file"
                          name="foto"
                          class="underline-input"
                          style="border:none"
                        />

                        <button
                          type="submit"
                          class="swal2-confirm swal2-styled"
                          style="margin-top: 15px; padding: 8px 20px"
                        >
                          Simpan
                        </button>
                      </form>
                    `,
                  showConfirmButton: false,
                  width: 350,
                  didOpen: () => {
                    const togglePassword = document.getElementById("togglePassword");
                    const passwordField = document.getElementById("passwordField");

                    togglePassword.addEventListener("click", function () {
                      if (passwordField.type === "password") {
                        passwordField.type = "text";
                        togglePassword.classList.remove("fa-eye");
                        togglePassword.classList.add("fa-eye-slash");
                      } else {
                        passwordField.type = "password";
                        togglePassword.classList.remove("fa-eye-slash");
                        togglePassword.classList.add("fa-eye");
                      }
                    });
                  },
                });
              });
          },
        });
      });

  </script>

  @if(session("success"))
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      Swal.fire({
        icon: "succes",
        title: "Berhasil!",
        text: "{{ session('success') }}",
        confirmButtonColor: "#3085d6",
      });
    });
  </script>
  @endif
</body>
</html>
