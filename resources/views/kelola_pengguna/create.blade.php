@extends('layout.template')
@section('title', 'Kelola Pengguna | Agrilink Vocpro')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('kelolaPengguna.store') }}" class="form-horizontal"
                    enctype="multipart/form-data" id="tambahPengguna">
                    @csrf
                    <div class=" form-group row">
                        <div class="col-12 col-lg-12 mt-3">
                            <div class="form-group">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" placeholder="Masukkan Username Pengguna"
                                    value="{{ old('username') }}" required>
                                <p><small class="text-muted">Wajib Diisi!</small></p>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="form-group">
                                <label for="fullname" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('fullname') is-invalid @enderror"
                                    id="fullname" name="fullname" placeholder="Masukkan Nama Lengkap"
                                    value="{{ old('fullname') }}" required>
                                <p><small class="text-muted">Wajib Diisi!</small></p>
                                @error('fullname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Masukkan Email Pengguna"
                                    value="{{ old('email') }}" required>

                                <p><small class="text-muted">Wajib Diisi!</small></p>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="window.location.href='{{ route('kelolaPengguna.index') }}'"
                            style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                        <button type="submit" class="btn btn-primary btn-sm"
                            style="background-color: #007BFF; border-color: #007BFF" id="btn-simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        document.getElementById('toggle-password').addEventListener('click', function(e) {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
@endpush
