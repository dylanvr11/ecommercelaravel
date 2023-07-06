<x-app title="Ecommerce">
    {{-- A product --}}
    <section class="d-flex justify-content-center flex-wrap">
        @foreach ($categories as $category)
            @if (count($category->Products)!=0)
            <div class="container mt-2">
                <h1>{{$category->name}}</h1>
            </div>
            <div>
                <a href="{{route('category.get',['category' => $category->id])}}" class="btn btn-primary mx-2">Ver mas</a>
            </div>
            {{-- @foreach ($category->Products as $product) --}}
            @foreach ($category->Products->where('stock', '>', 0)->take(4) as $product)
            <a href="{{ route('product.get',['product' => $product->id]) }}">
                <div class="card mx-3 my-3" style="width: 18rem;">
                    @if($product->image)
                        <img src="/storage/images/{{$product->image}}"         class="card-img-top" alt="Libro">
                    @else
                        <img src="https://previews.123rf.com/images/nosua/nosua1710/nosua171000361/88191655-colecci%C3%B3n-de-productos-electr%C3%B3nicos-de-consumo-que-vuelan-en-el-aire-3d-render-sobre-fondo-blanco.jpg"         class="card-img-top" alt="Libro">
                    @endif
                        <div class="card-body">
                            <h5 class="card-title">{{$product->name}}</h5>
                            <p class="card-text">{{$product->description}}</p>
                            <form action="{{route('add.cart.post')}}" method="post">
                            {{-- <form action="{{route('add.cart.post', ['order' => $order->id])}}" method="post"> --}}
                                @csrf
                                {{-- <h1>{{$order->administrator_user_id=1}}</h1>
                                <h1>{{$order->customer_user_id=auth()->id()}}</h1>
                                <h1>{{$order->price=$product->price}}</h1>
                                <h1>{{$order->product_id=$product->id}}</h1>
                                <h1>{{$order->quantity=1}}</h1>
                                <h1>{{$order}}</h1> --}}
                                <button type="submit" class="btn btn-primary btn-sm">Agregar</button>
                            </form>
                        </div>
                </div>
            </a>
            @endforeach
            <hr>
            @endif
        @endforeach
    </section>
</x-app>
