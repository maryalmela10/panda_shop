@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
<!-- Encabezado -->
<div class="container-fluid bg-light py-5">
    <div class="col-md-6 m-auto text-center">
        <h1 class="h1">Contáctanos</h1>
        <p>
            Estamos listos para ayudarte. Déjanos un mensaje o visítanos.
        </p>
    </div>
</div>

<!-- Mapa -->
<div id="mapid" style="width: 100%; height: 300px;"></div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
<script>
    var mymap = L.map('mapid').setView([-23.013104, -43.394365], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18
    }).addTo(mymap);
    L.marker([-23.013104, -43.394365]).addTo(mymap)
        .bindPopup("Estamos aquí").openPopup();
</script>
@endpush

<!-- Formulario de contacto -->
<div class="container py-5">
    <form class="col-md-9 m-auto" method="POST" action="#">
        {{-- @csrf si lo usas en back-end --}}
        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label for="name">Nombre</label>
                <input type="text" class="form-control mt-1" id="name" name="name" placeholder="Nombre completo">
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="email">Correo electrónico</label>
                <input type="email" class="form-control mt-1" id="email" name="email" placeholder="ejemplo@correo.com">
            </div>
        </div>
        <div class="mb-3">
            <label for="subject">Asunto</label>
            <input type="text" class="form-control mt-1" id="subject" name="subject" placeholder="Asunto del mensaje">
        </div>
        <div class="mb-3">
            <label for="message">Mensaje</label>
            <textarea class="form-control mt-1" id="message" name="message" rows="8" placeholder="Escribe tu mensaje aquí..."></textarea>
        </div>
        <div class="row">
            <div class="col text-end mt-2">
                <button type="submit" class="btn btn-success btn-lg px-3">Enviar</button>
            </div>
        </div>
    </form>
</div>
@endsection
