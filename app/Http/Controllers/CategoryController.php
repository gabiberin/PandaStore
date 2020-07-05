<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Product;
use App\Category;

class CategoryController extends Controller
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
        $categories = Category::all();

        return view('categories.index')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $category = new Category;

        $category->name          = $request->input('name');
        $category->author_id     = auth()->user()->id;
        $category->slug          = Str::slug($category->name);

        $category->save();

        return redirect('/')->with('success', 'Category Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->first();

        return view('categories.single')->with([
            'products'  => $category->products,
            'category'  => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->first();
        
        // Check if category exists
        if ( ! isset($category) ) {
            return redirect('/categories')->with('error', 'No Category Found');
        }

        // Check for correct user
        if ( auth()->user()->id != $category->author_id ) {
            return redirect('/categories')->with('error', 'You are not allowed to edit this category.');
        }

        return view('categories.edit')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {

        $this->validate($request, [
            'name' => 'required',
        ]);
        
        $category = Category::where('slug', $slug)->first();

        $category->name = $request->input('name');
        $category->slug = Str::slug($category->name);

        $category->save();

        return redirect('/categories')->with('success', 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $category = Category::where('slug', $slug)->first();
        
        // Check if category exists
        if ( ! isset($category) ) {
            return redirect('/categories')->with('error', 'No Category Found');
        }

        // Check for correct user
        if ( auth()->user()->id != $category->author_id ){
            return redirect('/categories')->with('error', 'You are not allowed to delete this category');
        }
        
        $category->delete();

        return redirect('/categories')->with('success', 'Category Removed');
    }
}
