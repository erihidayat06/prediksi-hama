@extends('layoute.main')

@section('content')
    <div class="container">
        <h1 class="my-4">Marketplace Obat Pertanian</h1>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($products as $product)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ $product['image_url'] }}" class="card-img-top" alt="{{ $product['name'] }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product['name'] }}</h5>
                            <p class="card-text">{{ Str::limit($product['description'], 100) }}</p>
                            <p class="card-text"><strong>Rp {{ number_format($product['price'], 0, ',', '.') }}</strong></p>
                            <a href="#" class="btn btn-primary">Beli</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
