@extends('layouts.app')

@section('content')
    <form method="POST" action="/categories">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="Minions" required>
            <small id="nameHelp" class="form-text text-muted">This is the name of your category</small>
        </div>

        {{ csrf_field() }}
        <button type="submit" class="btn btn-primary">Create Category</button>
  </form>
@endsection