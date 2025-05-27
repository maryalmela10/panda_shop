<form action="{{ route('dashboard.profile.destroy') }}" method="POST" class="mt-4"
    onsubmit="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.');">
    @csrf
    @method('DELETE')
    <div class="mb-3">
        <label for="delete_password" class="form-label color-destacado">
            <i class="fas fa-exclamation-triangle me-1"></i>
            Confirma tu contraseña para eliminar la cuenta <span class="text-danger">*</span>
        </label>
        <input type="password" name="password" id="delete_password"
            class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña">
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-danger px-4">
            <i class="fas fa-trash"></i> Eliminar cuenta
        </button>
    </div>
    <p class="form-text text-muted mt-2">
        Una vez que elimines tu cuenta, todos tus datos serán borrados permanentemente.
    </p>
</form>
