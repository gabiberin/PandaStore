@extends('layouts.app')

@section('content')
    <form method="POST" action="/categories/{{ $category->slug }}">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" value="{{ $category->name }}" placeholder="Minions" required>
            <small id="nameHelp" class="form-text text-muted">This is the name of your category</small>
        </div>

        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <button type="submit" class="btn btn-primary">Save Category</button>
  </form>
@endsection