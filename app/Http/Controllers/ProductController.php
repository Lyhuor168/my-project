<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getdata()
    {
        $search = request('search');
        $pro = Product::when($search, function ($query) use ($search) {
                $query->where('id', $search)
                      ->orWhere('name', 'like', '%'.$search.'%');
            })->get();
        return view('products.index', compact('pro'));
    }

    public function getdata2()
    {
        $search = request('search');
        $pro = Product::when($search, function ($query) use ($search) {
                $query->where('id', $search)
                      ->orWhere('name', 'like', '%'.$search.'%');
            })->paginate(4);
        return view('products.index', compact('pro'));
    }

    public function formProduct()
    {
        $categories = [1 => "Iced", 2 => "Hot", 3 => "Frappe", 4 => "Water", 5 => "Soft Drinks", 6 => "Energy Drinks"];
        return view('form_product', compact('categories'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'qty'         => 'required|integer|min:0',
            'description' => 'nullable|string',
            'img'         => 'nullable|image|max:2048',
        ]);

        $imgPath = null;
        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('products', 'public');
        }

        Product::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'qty'         => $request->qty,
            'description' => $request->description,
            'category_id' => $request->category_id ?? 1,
            'img'         => $imgPath,
        ]);
        return redirect()->route('product.index')->with('success', 'Product saved!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = [1 => "Iced", 2 => "Hot", 3 => "Frappe", 4 => "Water", 5 => "Soft Drinks", 6 => "Energy Drinks"];
        return view("form_product", compact("product", "categories"));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name"  => "required|string|max:255",
            "price" => "required|numeric|min:0",
            "qty"   => "required|integer|min:0",
            'img'   => 'nullable|image|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $imgPath = $product->img;
        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('products', 'public');
        }

        $product->update([
            "name"        => $request->name,
            "price"       => $request->price,
            "qty"         => $request->qty,
            "description" => $request->description,
            "category_id" => $request->category_id ?? $product->category_id,
            "img"         => $imgPath,
        ]);
        return redirect()->route("product.index")->with("success", "Product updated!");
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route("product.index")->with("success", "Product deleted!");
    }
}
