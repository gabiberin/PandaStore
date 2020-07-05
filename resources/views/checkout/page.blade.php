@extends('layouts.app')

@section('content')
    <h1 class="mb-5">Checkout</h1>
    <form method="POST" action="/checkout">
        <div class="row">
        
            <div class="col-12 col-md-6">
                <h3 class="mb-4">Customer Details</h3>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="shipping_first_name">First Name</label>
                        <input type="text" value="{{ $customer->shipping_first_name ?? '' }}" class="form-control" name="shipping_first_name" id="shipping_first_name" placeholder="John" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="shipping_last_name">Last Name</label>
                        <input type="text" class="form-control" value="{{ $customer->shipping_last_name ?? '' }}" name="shipping_last_name" id="shipping_last_name" placeholder="Doe" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="shipping_address">Address</label>
                    <input type="text" class="form-control" value="{{ $customer->shipping_address ?? '' }}" name="shipping_address" id="shipping_address" placeholder="1234 Foobar St" required>
                </div>
                <div class="form-row">
                    <div class="form-group col-lg-6 col-12">
                        <label for="shipping_city">City</label>
                        <input type="text" class="form-control" value="{{ $customer->shipping_city ?? '' }}" name="shipping_city" id="shipping_city" required>
                    </div>
                    <div class="form-group col-lg-4 col-6">
                        <label for="shipping_state">State</label>
                        <input type="text" class="form-control" value="{{ $customer->shipping_state ?? '' }}" name="shipping_state" id="shipping_state" required>
                    </div>
                    <div class="form-group col-lg-2 col-6">
                        <label for="shipping_postal_code">Postal Code</label>
                        <input type="text" class="form-control" value="{{ $customer->shipping_postal_code ?? '' }}" name="shipping_postal_code" id="shipping_postal_code" required>
                    </div>
                    <div class="form-group col-12">
                        <label for="shipping_postal_code">Country</label>
                        <select class="form-control" name="shipping_country" id="shipping_country" required>
                            <option value="" disabled selected>Choose a country</option>
                            @foreach ($countries as $country)
                                @if ( isset($customer) )
                                    @if ( $customer->country_code == $country->code )
                                        <option value="{{ $country->code }}" selected>{{ $country->name }}</option>
                                    @else
                                        <option value="{{ $country->code }}">{{ $country->name }}</option>
                                    @endif
                                @else
                                    <option value="{{ $country->code }}">{{ $country->name }}</option>
                                @endif
                            @endforeach
                          </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <table style="border: 1px solid #ccc" class="table table-hover">
                    <thead>
                        <tr>
                            <th style="border-top:none">Product</th>
                            <th style="border-top:none"class="text-center">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ( Cart::count() > 0 )
                            @foreach (Cart::content() as $item)
                                <tr>
                                    <td class="col-7">
                                        <div class="media align-items-center">
                                            <a class="thumbnail pull-left" href="#"> <img class="media-object mr-4" src="{{ $item->model->image_url }}" style="width: 72px; height: 72px;"> </a>
                                            <div class="media-body">
                                                <h5 class="media-heading">{{ $item->model->name }}</h5>
                                                <span class="media-heading"> by {{ $item->model->user->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="col-3 text-center"><strong>${{ $item->subtotal }}</strong></td>
                                </tr>
                            @endforeach
                        @else
                            <h2>No items in cart!</h2>
                        @endif
                        <tr>
                            <td><h4 class="float-right">Total:</h4></td>
                            <td class="text-right"><h4><strong>${{Cart::total()}}</strong></h4></td>
                        </tr>
                        <tr>
                            <td>
                                <a href="/" class="btn btn-secondary">Continue Shopping</a>
                            </td>
                            <td>
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-success">Checkout</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        
        </div>
    </form>
@endsection

@section('extra_js')
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

          let shipping_country = new Choices(document.getElementById('shipping_country'));

        });
        </script>
@endsection