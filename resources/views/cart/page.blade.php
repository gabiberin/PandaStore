@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-center">Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ( Cart::count() > 0 )
                        @foreach (Cart::content() as $item)
                            <tr>
                                <td class="col-sm-8 col-md-6">
                                    <div class="media align-items-center">
                                        <a class="thumbnail pull-left" href="#"> <img class="media-object mr-4" src="{{ $item->model->image_url }}" style="width: 72px; height: 72px;"> </a>
                                        <div class="media-body">
                                            <h5 class="media-heading">{{ $item->model->name }}</h5>
                                            <span class="media-heading"> by {{ $item->model->user->name }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-sm-1 col-md-1 text-center"><strong>${{ $item->subtotal }}</strong></td>
                                <td class="col-sm-1 col-md-1">
                                    <form action="/cart/{{ $item->rowId }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <h2>No items in cart!</h2>
                    @endif
                    <tr>
                        <td>   </td>
                        <td><h3>Total</h3></td>
                        <td class="text-right"><h3><strong>${{Cart::total()}}</strong></h3></td>
                    </tr>
                    <tr>
                        <td>  <a href="/" class="btn btn-secondary">Continue Shopping</a> </td>
                        <td>
                            
                        </td>
                        <td>
                            <a href="/checkout" class="btn btn-success">Checkout</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection