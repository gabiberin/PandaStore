@extends('layouts.app')

@section('content')

    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading mb-4">Category: {{ $category->name }}</h1>
            @if ( !Auth::guest() && Auth::user()->id == $category->author_id )
                <div>
                    <a href="/categories/{{ $category->slug }}/edit" class="btn btn-secondary">Edit</a>
                    <form method="POST" action="/categories/{{ $category->slug }}" class="d-inline-block">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            @endif
        </div>
    </section>

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                    <img class="card-img-top" src="{{ $product->image_url }}" alt="Product Image" style="height: 100%; width: 100%; display: block;">
                    <div class="card-body">
                        <h5 class="card-title mb-2">{{ $product->name }}</h5>
                        <div class="card-subtitle mb-2 text-muted">
                            @foreach ($product->categories as $index => $category)
                                <a class="" href="/categories/{{ $category->slug }}/">{{ $category->name }}</a>
                                @if ( $index != count($product->categories)-1 )
                                    |
                                @endif
                            @endforeach
                        </div>
                        <p class="card-text">{{ $product->description }}</p>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            @if ( !Auth::guest() && Auth::user()->id == $product->author_id )
                                <span>${{ $product->price }}</span>
                                <div class="d-flex flex-wrap">
                                    <a href="/products/{{ $product->id }}/edit" class="btn btn-outline-secondary mr-1">Edit</a>
                                    <form method="POST" action="/products/{{ $product->id }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            @else
                                <div class="btn-group" role="group">
                                    <button class="btn btn-outline-dark product-price border-right-0">${{ $product->price }}</button>
                                    <form action="/cart" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                        <button class="btn btn-outline-primary" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">Add to Cart</button>
                                    </form>
                                </div>
                                <small class="text-muted">By: {{ $product->user->name }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 display-5">No items found</div>
        @endforelse
    </div>
@endsection