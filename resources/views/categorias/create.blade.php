@extends('layouts.app')

@section('title', 'Crear categoría')

@section('content')
    <div class="container py-5">
        <h2 class="h2 mb-4">Nueva categoría</h2>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="dashboard-card">
                    <form action="{{ route('admin.categorias.store') }}" method="POST" autocomplete="off">
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
                            <!-- Imagen -->
                            <div class="col-md-6">
                                <label for="imagen" class="form-label color-destacado">URL de imagen</label>
                                <input type="url" name="imagen" id="imagen" class="form-control @error('imagen') is-invalid @enderror" value="{{ old('imagen') }}">
                                @error('imagen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Descripción -->
                            <div class="col-12">
                                <label for="descripcion" class="form-label color-destacado">Descripción</label>
                                <textarea name="descripcion" id="descripcion" rows="4" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save"></i> Guardar categoría
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
