<form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('PUT')

    {{-- Password Lama --}}
    <div class="mb-3">
        <label for="current_password" class="form-label fw-semibold">Password Saat Ini</label>
        <input type="password" id="current_password" name="current_password"
            class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
            autocomplete="current-password">
        @error('current_password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Password Baru --}}
    <div class="mb-3">
        <label for="password" class="form-label fw-semibold">Password Baru</label>
        <input type="password" id="password" name="password"
            class="form-control @error('password', 'updatePassword') is-invalid @enderror"
            autocomplete="new-password">
        @error('password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Konfirmasi Password --}}
    <div class="mb-3">
        <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
            class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
            autocomplete="new-password">
        @error('password_confirmation', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-warning">
            <i class="fas fa-key me-1"></i> Ubah Password
        </button>
        @if (session('status') === 'password-updated')
            <span class="text-success"><i class="fas fa-check-circle me-1"></i> Password diperbarui!</span>
        @endif
    </div>
</form>
