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
            })
            ->get();

        return view('showdata', compact('pro'));
    }

    public function getdata2()
    {
        $search = request('search');
        $pro = Product::when($search, function ($query) use ($search) {
                $query->where('id', $search)
                      ->orWhere('name', 'like', '%'.$search.'%');
            })
            ->paginate(4);

        return view('showdata', compact('pro'));
    }
}
