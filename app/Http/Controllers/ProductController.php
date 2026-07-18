<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  
    public function index()
    {
        $products = Product::all();
        return view('products.index',compact('products'));
    }
  
    public function create(Request $request)
    {
          return view('products.create');
    }

 
   public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imageName = null;
        if($request->hasFile('image')){
            $imageName = time() . '.' . 
            $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
        }

        Product::create([
            'name'  => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imageName,  
        ]);

        return redirect('/products')->with('success', 'Coffee added!');
    }

 
    public function show(Product $product)
    {
       
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imageName = $product->image;

        if($request->hasFile('image')){
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
        }

        $product->update([
            'name'  => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imageName,
        ]);

        return redirect('/products')->with('success', 'Coffee updated!');
    }
 
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/products')->with('success', 'Coffee deleted!');
    }


}

