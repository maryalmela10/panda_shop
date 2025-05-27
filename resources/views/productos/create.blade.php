@extends('layouts.app')

@section('title', 'Crear producto')

@section('content')
    <div class="container py-5">
        <h2 class="h2 mb-4">Nuevo producto</h2>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="dashboard-card">
                    <form action="{{ route('admin.productos.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <!-- Nombre -->
                            <div class="col-md-6">
                                <label for="nombre" class="form-label color-destacado">Nombre <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Precio -->
                            <div class="col-md-3">
                                <label for="precio" class="form-label color-destacado">Precio <span class="text-danger">*</span></label>
                                <input type="number" name="precio" id="precio" class="form-control @error('precio') is-invalid @enderror" value="{{ old('precio') }}" step="0.01" min="0" required>
                                @error('precio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Stock -->
                            <div class="col-md-3">
                                <label for="stock" class="form-label color-destacado">Stock <span class="text-danger">*</span></label>
                                <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}" min="0" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Categoría -->
                            <div class="col-md-6">
                                <label for="categoria_id" class="form-label color-destacado">Categoría <span class="text-danger">*</span></label>
                                <select name="categoria_id" id="categoria_id" class="form-select @error('categoria_id') is-invalid @enderror" required>
                                    <option value="">Selecciona una categoría</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoria_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Imagen local -->
                            <div class="col-md-6">
                                <label for="imagen" class="form-label color-destacado">Imagen</label>
                                <input type="file" name="imagen" id="imagen"
                                    class="form-control @error('imagen') is-invalid @enderror"
                                    accept="image/*">
                                @error('imagen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Disponible -->
                            <div class="col-md-4">
                                <label for="disponible" class="form-label color-destacado">Disponible</label>
                                <select name="disponible" id="disponible" class="form-select @error('disponible') is-invalid @enderror">
                                    <option value="1" {{ old('disponible', 1) == 1 ? 'selected' : '' }}>Sí</option>
                                    <option value="0" {{ old('disponible') == 0 ? 'selected' : '' }}>No</option>
                                </select>
                                @error('disponible')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Fecha de reposición -->
                            <div class="col-md-4">
                                <label for="fecha_reposicion" class="form-label color-destacado">Fecha de reposición</label>
                                <input type="date" name="fecha_reposicion" id="fecha_reposicion" class="form-control @error('fecha_reposicion') is-invalid @enderror" value="{{ old('fecha_reposicion') }}">
                                @error('fecha_reposicion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Descripción -->
                            <div class="col-12">
                                <label for="descripcion" class="form-label color-destacado">Descripción <span class="text-danger">*</span></label>
                                <textarea name="descripcion" id="descripcion" rows="4" class="form-control @error('descripcion') is-invalid @enderror" required>{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save"></i> Guardar producto
                            </button>
                            <a href="{{ route('shop') }}" class="btn btn-outline-secondary ms-2">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
