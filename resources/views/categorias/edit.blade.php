@extends('layouts.app')

@section('title', 'Editar categoría')

@section('content')
    <div class="container py-5">
        <h2 class="h2 mb-4">Editar categoría</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="dashboard-card">
                    {{-- Formulario de eliminar (izquierda) y botones de editar (derecha) --}}
                    <div class="row mt-4 mb-3">
                        <div class="col d-flex align-items-center justify-content-between">
                            {{-- Botón eliminar a la izquierda --}}
                            <form action="{{ route('admin.categorias.destroy', $categoria->id) }}" method="POST"
                                  onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                            {{-- Botón volver a la tienda (derecha) --}}
                            <a href="{{ route('shop') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                    {{-- Formulario de edición --}}
                    <form action="{{ route('admin.categorias.update', $categoria->id) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label color-destacado">Nombre <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $categoria->nombre) }}" required>
                                @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="imagen" class="form-label color-destacado">Imagen</label>
                                <input type="file" name="imagen" id="imagen"
                                    class="form-control @error('imagen') is-invalid @enderror"
                                    accept="image/*">
                                @error('imagen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="descripcion" class="form-label color-destacado">Descripción</label>
                                <textarea name="descripcion" id="descripcion" rows="4" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                                @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-4 gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save"></i> Guardar cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
