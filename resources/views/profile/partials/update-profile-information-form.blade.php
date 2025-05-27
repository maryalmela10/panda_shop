<form action="{{ route('dashboard.profile.update') }}" method="POST" autocomplete="off" class="mb-4">
    @csrf
    @method('PATCH')
    <div class="row g-4">
        <div class="col-md-6">
            <label for="name" class="form-label color-destacado">Nombre <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label color-destacado">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" id="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
            <label for="address" class="form-label color-destacado">Dirección</label>
            <input type="text" name="address" id="address"
                class="form-control @error('address') is-invalid @enderror"
                value="{{ old('address', $user->address) }}" autocomplete="street-address">
            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
            <label for="phone" class="form-label color-destacado">Teléfono</label>
            <input type="text" name="phone" id="phone"
                class="form-control @error('phone') is-invalid @enderror"
                value="{{ old('phone', $user->phone) }}" autocomplete="tel">
            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-success px-4">
            <i class="fas fa-save"></i> Guardar cambios
        </button>
    </div>
</form>
