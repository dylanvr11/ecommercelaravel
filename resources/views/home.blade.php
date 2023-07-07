<x-app title="Ecommerce">
    {{-- Categories with product --}}
    <section class="d-flex justify-content-center flex-wrap">
        @foreach ($categories as $category)
            @if (count($category->Products)!=0)
            <div class="container mt-2">
                <a href="{{ route('category.get', ['category' => $category->id]) }}">
                    <h1 class="category-heading">{{ $category->name }}</h1>
                </a>
            </div>
            @foreach ($category->Products->where('stock', '>', 0)->take(4) as $product)
            <a href="{{ route('product.get',['product' => $product->id]) }}">
                <div class="card mx-3 my-3" style="width: 18rem;">
                    @if($product->image)
                        <img src="/storage/images/{{$product->image}}"         class="card-img-top" alt="Libro">
                    @else
                        <img src="https://previews.123rf.com/images/nosua/nosua1710/nosua171000361/88191655-colecci%C3%B3n-de-productos-electr%C3%B3nicos-de-consumo-que-vuelan-en-el-aire-3d-render-sobre-fondo-blanco.jpg"         class="card-img-top" alt="Libro">
                    @endif
            </a>
                        <div class="card-body">
                            <h5 class="card-title">{{$product->name}}</h5>
                            <p class="card-text">{{$product->description}}</p>
                            <p class="card-text">Stock: {{$product->stock}}</p>
                            <form action="{{route('add.cart.post',['product'=>$product->id])}}" method="post">
                                @csrf
                                <input type="number" name="quantity">
                                <button type="submit" class="btn btn-primary btn-sm">Agregar</button>
                            </form>
                        </div>
                </div>
            @endforeach
            <hr>
            @endif
        @endforeach
    </section>
</x-app>
