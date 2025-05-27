<form action="{{ route('password.update') }}" method="POST" autocomplete="off" class="mb-4">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="col-md-6">
            <label for="current_password" class="form-label color-destacado">
                <i class="fas fa-lock me-1"></i>Contraseña actual <span class="text-danger">*</span>
            </label>
            <input type="password" name="current_password" id="current_password"
                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">

            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="password" class="form-label color-destacado">
                <i class="fas fa-key me-1"></i>Nueva contraseña <span class="text-danger">*</span>
            </label>
            <input type="password" name="password" id="password"
                class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                autocomplete="new-password" placeholder="Nueva contraseña">
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="password_confirmation" class="form-label color-destacado">
                <i class="fas fa-key me-1"></i>Confirmar nueva contraseña <span class="text-danger">*</span>
            </label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                autocomplete="new-password" placeholder="Confirma la nueva contraseña">
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-warning px-4">
            <i class="fas fa-key"></i> Cambiar contraseña
        </button>
    </div>
</form>
