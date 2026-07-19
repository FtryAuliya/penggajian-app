<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    {{-- Nama --}}
    <div class="mb-3">
        <label for="name" class="form-label fw-semibold">Nama</label>
        <input type="text" id="name" name="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name) }}" required autofocus>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Email --}}
    <div class="mb-3">
        <label for="email" class="form-label fw-semibold">Email</label>
        <input type="email" id="email" name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $user->email) }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> Simpan
        </button>
        @if (session('status') === 'profile-updated')
            <span class="text-success"><i class="fas fa-check-circle me-1"></i> Tersimpan!</span>
        @endif
    </div>
</form>
