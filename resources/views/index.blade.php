{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h1>Hola mundo</h1>
</div>
@endsection --}}

<x-app title="Ecommerce">
    {{-- A product --}}
    <section class="d-flex justify-content-center flex-wrap">
        @foreach ($products as $product)
            <div class="card mx-3 my-3" style="width: 18rem;">
                <img src="https://previews.123rf.com/images/nosua/nosua1710/nosua171000361/88191655-colecci%C3%B3n-de-productos-electr%C3%B3nicos-de-consumo-que-vuelan-en-el-aire-3d-render-sobre-fondo-blanco.jpg"         class="card-img-top" alt="Libro">
                <div class="card-body">
                  <h5 class="card-title">{{$product->name}}</h5>
                  <p class="card-text">{{$product->description}}</p>
                  <a href="#" class="btn btn-primary">Comprar</a>
                </div>
            </div>
        @endforeach
    </section>
</x-app>