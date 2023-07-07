<x-app title="Ecommerce">
    {{-- A product --}}
    <section class="d-flex justify-content-center flex-wrap">
            <div class="container mt-2">
                <h1>{{$product->name}}</h1>
            </div>

            <div class="card mx-3 my-3" style="width: 18rem;">
                @if($product->image)
                    <img src="/storage/images/{{$product->image}}"         class="card-img-top" alt="Libro">
                @else
                    <img src="https://previews.123rf.com/images/nosua/nosua1710/nosua171000361/88191655-colecci%C3%B3n-de-productos-electr%C3%B3nicos-de-consumo-que-vuelan-en-el-aire-3d-render-sobre-fondo-blanco.jpg"         class="card-img-top" alt="Libro">
                @endif
                    <div class="card-body">
                        <p class="card-text">Categoria: {{$product->category->name}}</p>
                        <p class="card-text">Descripcion: {{$product->description}}</p>
                        <p class="card-text">Precio: {{$product->price}}</p>
                        <p class="card-text">Stock: {{$product->stock}}</p>
                        <form action="{{route('add.cart.post',['product'=>$product->id])}}" method="post">
                            @csrf
                            <input type="number" name="quantity">
                            <button type="submit" class="btn btn-primary btn-sm">Agregar</button>
                        </form>
                    </div>
            </div>
            <hr>
    </section>
</x-app>
