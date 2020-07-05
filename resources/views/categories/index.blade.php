@extends('layouts.app')

@section('content')

    <div class="row">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col" >Actions</th>
              </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <th scope="row">{{ $category->id }}</th>
                        <td>{{ $category->name }}</td>
                        <td>
                            @if ( !Auth::guest() && Auth::user()->id == $category->author_id )
                                <div class="d-flex flex-wrap">
                                    <a href="/categories/{{ $category->slug }}/edit" class="btn btn-outline-primary mr-1">Edit</a>
                                    <form method="POST" action="/categories/{{ $category->slug }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            @else
                            <a href="/categories/{{ $category->slug }}" class="btn btn-outline-secondary">View</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <div class="col-12 display-5">No items found</div>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection