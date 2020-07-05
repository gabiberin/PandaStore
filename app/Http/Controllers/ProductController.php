<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Category;
use App\ProductCategory;

class ProductController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [ 'index', 'show' ]
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(6);

        return view('products.shop')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::select('slug','name')->get();

        return view('products.create')->with( 'categories', $categories );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;

        $product->name          = $request->input('name');
        $product->description   = $request->input('description');
        $product->price         = $request->input('price');
        $product->author_id     = auth()->user()->id;
        $product->image_url     = $request->input('image_url');

        $product->save();

        if ( $request->input('product_categories') ) {
            $this->add_product_categories($product->id, $request->input('product_categories'));
        }

        return redirect('/')->with('success', 'Product Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        return view('products.single')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        
        // Check if product exists
        if ( ! isset($product) ) {
            return redirect('/')->with('error', 'No Product Found');
        }

        $current_user_id = auth()->user()->id;

        // Check for correct user
        if ( $current_user_id != $product->author_id ) {
            return redirect('/')->with('error', 'You are not allowed to edit this product.');
        }

        $categories = Category::all();

        return view('products.edit')->with([
            'product'       => $product,
            'categories'    => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        $product->name          = $request->input('name');
        $product->description   = $request->input('description');
        $product->price         = $request->input('price');
        $product->image_url     = $request->input('image_url');

        $product->save();

        if ( $request->input('product_categories') ) {
            $this->add_product_categories($product->id, $request->input('product_categories.*'));
        }

        return redirect('/')->with('success', 'Product Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        
        // Check if product exists
        if ( ! isset($product) ) {
            return redirect('/')->with('error', 'No Product Found');
        }

        // Check for correct user
        if ( auth()->user()->id != $product->author_id ){
            return redirect('/')->with('error', 'You are not allowed to delete this product');
        }
        
        $product->delete();

        return redirect('/')->with('success', 'Product Removed');
    }

    /**
     * Add categories to products
     *
     * @param int $product_id product id
     * @param array $categories product categories selected by the user
     */
    public function add_product_categories($product_id, $categories) {
        if ( ! is_array($categories) ) {
            $categories = array( $categories );
        }
        foreach ( $categories as $category_slug ) {

            $category = Category::where('slug', $category_slug)->first();
            if ( ! $category ) {
                continue;
            }

            ProductCategory::firstOrCreate([
                'category_id'   => $category->id,
                'product_id'    => $product_id
            ]);

        }
    }
}
