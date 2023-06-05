<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();

        $data = [];

        foreach ($products as $product) {
            $category = $categories->find($product->product_category_id);
            $subcategory = $subcategories->find($product->product_subcategory_id);
            
            $data[] = [
                'name' => $product->product_name,
                'product_img' => $product->product_img,
                'category' => optional($category)->category_name,
                'subcategory' => optional($subcategory)->subcategory_name,
                'product_short_des' => $product->product_short_des,
                'product_long_des' => $product->product_long_des,
                'price' => $product->price,
                'quantity' => $product->quantity,
            ];
        }

        return response(json_encode($data, JSON_UNESCAPED_UNICODE))
            ->header('Content-Type', 'application/json');
    }
}
