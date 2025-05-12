<div id="panda-carousel" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
        <li data-bs-target="#panda-carousel" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#panda-carousel" data-bs-slide-to="1"></li>
        <li data-bs-target="#panda-carousel" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        @php
            $slides = [
                [
                    'img' => 'banner_img_01.jpg',
                    'title' => 'La base de tus recetas, en un solo clic',
                    'subtitle' => 'Harinas de trigo, avena, almendra y más, frescas y al mejor precio.',
                    'text' => 'Compra desde casa y recibe donde lo necesites. Calidad garantizada.',
                ],
                [
                    'img' => 'banner_img_02.jpg',
                    'title' => 'Ingredientes frescos para resultados perfectos',
                    'subtitle' => 'Huevos seleccionados ideales para panadería y repostería.',
                    'text' => 'Combina calidad y frescura en cada compra. Reposición constante.',
                ],
                [
                    'img' => 'banner_img_03.jpg',
                    'title' => 'Chocolates que enamoran',
                    'subtitle' => 'Variedad en chocolate oscuro, blanco y con leche.',
                    'text' => 'Perfecto para repostería profesional y casera. ¡Déjate tentar!',
                ],
            ];
        @endphp
    
        @foreach ($slides as $index => $slide)
        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
            <div class="container">
                <div class="row p-5">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="{{ asset('assets/img/' . $slide['img']) }}" alt="Slide {{ $index + 1 }}">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left align-self-center">
                            <h1 class="h1">{{ $slide['title'] }}</h1>
                            <h3 class="h2">{{ $slide['subtitle'] }}</h3>
                            <p>{{ $slide['text'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#panda-carousel" role="button" data-bs-slide="prev">
        <i class="fas fa-chevron-left"></i>
    </a>
    <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#panda-carousel" role="button" data-bs-slide="next">
        <i class="fas fa-chevron-right"></i>
    </a>
</div>