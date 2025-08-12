<script>
document.addEventListener('DOMContentLoaded', function () {
    const profileImageSidebar = document.getElementById('profileImageSidebar');
    if (!profileImageSidebar) return;

    profileImageSidebar.addEventListener('click', function () {
        const fotoUrl = "{{ $admin->foto ? asset('storage/'.$admin->foto) : 'https://randomuser.me/api/portraits/men/75.jpg' }}";
        const nama = "{{ $admin->nama_admin }}";
        const passwordSekarang = "{{ $admin->password_plain ?? '••••••••' }}";

        function showProfilePopup() {
            Swal.fire({
                title: 'Profil Admin',
                html: `
                  <div class="profile-popup" style="text-align:center;position:relative">
                    <i id="editProfileIcon" class="fas fa-edit" style="position:absolute;top:15px;right:15px;font-size:18px;color:#3085d6;cursor:pointer"></i>
                    <img id="zoomProfileImage" src="${fotoUrl}" class="profile-pic">
                    <div style="font-size:16px;font-weight:bold;margin-top:10px">${nama}</div>
                    <div style="font-size:14px;margin-top:5px;display:inline-flex;align-items:center;gap:5px">
                      <span id="passwordDisplay">••••••••</span>
                      <i id="togglePasswordMain" class="fas fa-eye" style="cursor:pointer;color:gray"></i>
                    </div>
                  </div>
                `,
                showConfirmButton: false,
                width: 350,
                didOpen: () => {
                    document.getElementById('zoomProfileImage').addEventListener('click', function () {
                        Swal.fire({
                            imageUrl: fotoUrl,
                            imageAlt: 'Foto Profil',
                            showCloseButton: true,
                            showConfirmButton: false,
                            background: '#000',
                            backdrop: `rgba(0,0,0,0.9)`
                        }).then(() => { showProfilePopup(); });
                    });

                    const toggleMain = document.getElementById('togglePasswordMain');
                    const passDisplay = document.getElementById('passwordDisplay');
                    let visible = false;
                    toggleMain.addEventListener('click', function () {
                        visible = !visible;
                        passDisplay.textContent = visible ? passwordSekarang : '••••••••';
                        toggleMain.classList.toggle('fa-eye', !visible);
                        toggleMain.classList.toggle('fa-eye-slash', visible);
                    });

                    document.getElementById('editProfileIcon').addEventListener('click', function () {
                        Swal.fire({
                            title: 'Edit Profil',
                            html: `
                              <form id="editProfileForm" enctype="multipart/form-data" method="POST" action="{{ route('admin.updateProfil') }}">
                                @csrf
                                <input type="text" name="nama_admin" value="${nama}" required style="width:100%;padding:8px 0;margin:10px 0;border:none;border-bottom:2px solid #ccc;outline:none">
                                <div style="position:relative">
                                  <input type="password" id="passwordField" name="password" placeholder="Password baru" style="width:100%;padding:8px 0;margin:10px 0;border:none;border-bottom:2px solid #ccc;outline:none">
                                  <i id="togglePassword" class="fas fa-eye" style="position:absolute;right:0;top:50%;transform:translateY(-50%);cursor:pointer;color:gray"></i>
                                </div>
                                <input type="file" name="foto" style="margin:10px 0">
                                <button type="submit" class="swal2-confirm swal2-styled" style="margin-top:15px;padding:8px 20px;">Simpan</button>
                              </form>
                            `,
                            showConfirmButton: false,
                            width: 350,
                            didOpen: () => {
                                document.getElementById('togglePassword').addEventListener('click', function () {
                                    const passwordField = document.getElementById('passwordField');
                                    const isPassword = passwordField.type === 'password';
                                    passwordField.type = isPassword ? 'text' : 'password';
                                    this.classList.toggle('fa-eye', !isPassword);
                                    this.classList.toggle('fa-eye-slash', isPassword);
                                });

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
});
</script>
