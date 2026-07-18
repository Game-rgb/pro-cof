<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::latest()->get();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        // where : if stock > 0 
        $products = Product::where('stock', '>', 0)->get();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'quantities'   => 'required|array',
            'quantities.*' => 'integer|min:0',
        ]);

        $total     = 0;
        $cartItems = [];

        foreach ($request->quantities as $product_id => $quantity) {
            if(!$quantity || $quantity < 1) continue;

            $product = Product::findOrFail($product_id);

            $subtotal    = $product->price * $quantity;
            $total      += $subtotal;

            $cartItems[] = [
                'product'  => $product,
                'quantity' => $quantity,
                'price'    => $product->price,
                'subtotal' => $subtotal,
            ];
        }

        if(empty($cartItems)){
            return back()->with('error', 'Please select at least one coffee!');
        }

        $sale = Sale::create(['total_amount' => $total]);

        foreach($cartItems as $item){
            SaleItem::create([
                'sale_id'    => $sale->id,
                'product_id' => $item['product']->id,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
                'subtotal'   => $item['subtotal'],
            ]);

            $item['product']->decrement('stock', $item['quantity']);
        }

        return redirect('/sales')->with('success', 'Sale completed!');
    }

    public function show(Sale $sale)
    {
        $sale->load('items.product');
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale){}
    public function update(Request $request, Sale $sale){}
    public function destroy(Sale $sale){}
}