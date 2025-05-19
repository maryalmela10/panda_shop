<div class="col-lg-3">
    <h1 class="h2 templatemo-accordion-title">Categorías</h1>
    <ul class="list-unstyled templatemo-accordion">
        <!-- Botón para mostrar todos los productos -->
        <li class="pb-3">
            <form action="{{ route('shop') }}" method="GET">
                <button type="submit" class="collapsed d-flex justify-content-between h3 text-decoration-none all-categories">
                    Todas las categorías
                    <i class="fa fa-fw fa-chevron-circle-down mt-1"></i>
                </button>
            </form>
        </li>
        <!-- Categorías -->
        @foreach ($categories as $category)
            <li class="pb-3">
                <form action="{{ route('shop') }}" method="GET">
                    <input type="hidden" name="categoria_id" value="{{ $category->id }}">
                    <button type="submit" class="collapsed d-flex justify-content-between h3 text-decoration-none {{ $category->id == $selectedCategory ? 'active-category' : '' }}">
                        {{ $category->nombre }}
                        <i class="fa fa-fw fa-chevron-circle-down mt-1"></i>
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
</div>

