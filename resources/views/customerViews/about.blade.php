@extends('layouts.app')

@section('title', 'Sobre Nosotros')

@section('content')
@if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif
<!-- Start About Page -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center py-5">
            <div class="col-md-6">
                <h1>Sobre Panda</h1>
                <p>
                    Somos una tienda enfocada en ofrecer productos de calidad para panadería y repostería. Desde harinas seleccionadas hasta chocolates premium, buscamos hacerte la vida más dulce y deliciosa.
                </p>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('assets/img/about-hero.svg') }}" alt="About Hero">
            </div>
        </div>
    </div>
</section>

<!-- Start Feature -->
<section class="container py-5">
    <div class="row text-center pt-5 pb-3">
        <div class="col-lg-6 m-auto">
            <h1 class="h1">Nuestros valores</h1>
            <p>
                Comprometidos con la excelencia, el sabor y la sostenibilidad.
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 pb-5">
            <div class="h-100 py-5 services-icon-wap shadow">
                <div class="h1 text-success text-center"><i class="fa fa-truck fa-lg"></i></div>
                <h2 class="h5 mt-4 text-center">Envíos rápidos</h2>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 pb-5">
            <div class="h-100 py-5 services-icon-wap shadow">
                <div class="h1 text-success text-center"><i class="fas fa-exchange-alt"></i></div>
                <h2 class="h5 mt-4 text-center">Garantía de satisfacción</h2>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 pb-5">
            <div class="h-100 py-5 services-icon-wap shadow">
                <div class="h1 text-success text-center"><i class="fa fa-percent"></i></div>
                <h2 class="h5 mt-4 text-center">Ofertas semanales</h2>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 pb-5">
            <div class="h-100 py-5 services-icon-wap shadow">
                <div class="h1 text-success text-center"><i class="fa fa-user"></i></div>
                <h2 class="h5 mt-4 text-center">Atención personalizada</h2>
            </div>
        </div>
    </div>
</section>
@endsection
