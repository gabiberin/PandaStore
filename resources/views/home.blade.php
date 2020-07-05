@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1 class="display-5 mb-4">Shop Customers</h1>
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Orders</th>
                        <th scope="col">Country</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                        <tr>
                            <th scope="row">{{ $customer->user_id }}</th>
                            <td>{{ $customer->shipping_first_name }}</td>
                            <td>{{ $customer->shipping_last_name }}</td>
                            <td>{{ count($customer->orders) }}</td>
                            <td>{{ $customer->country->name }}</td>
                            <td>
                                <form method="POST" action="/customers/{{ $customer->user_id }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-outline-danger">Delete Customer Information</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <h5>No customers found!</h5>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
