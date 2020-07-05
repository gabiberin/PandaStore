@extends('layouts.app')

@section('content')
    <form method="POST" action="/products">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="Panda Sticker" required>
            <small id="nameHelp" class="form-text text-muted">This is the name of your product</small>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" placeholder="My product is awesome!" required></textarea>
        </div>
        <div class="form-group">
            <label for="image_url">Image URL</label>
            <input type="text" class="form-control" name="image_url" id="image_url" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                </div>
                
                <input type="number" class="form-control" name="price" id="price" required>
            </div>
        </div>
        <div class="form-group">
            <label for="product_categories">Product Categories</label>
            <select
                class="form-control"
                name="product_categories[]"
                id="product_categories"
                placeholder="Choose Categories"
                multiple
                >
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}" >{{ $category->name }}</option>
                @endforeach
                
            </select>
        </div>

        {{ csrf_field() }}
        <button type="submit" class="btn btn-primary">Create Product</button>
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

          let product_categories = new Choices('#product_categories', { removeItemButton: true });

        });
        </script>
@endsection