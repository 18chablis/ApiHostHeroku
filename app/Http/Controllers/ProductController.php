<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //
    public function addProduct(Request $request){
        $product = new Product;

        $product->name = $request->input('name');
        $product->file_path = $request->file('file_path')->store('products');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->save();

        return $product;

    }

    public function index(){
        return Product::all();
    }

    public function delete($id){
        $result = Product::where('id', $id)->delete();

        if($result){
            return ["result" => "Product has been deleted"];
        }
        else{
            return ["result" => "Failed to delete"];
        }
    }

    public function getSingleProduct($id){
        return Product::find($id);
    }

    public function updateProduct(Request $request, $id){
        $product = Product::find($id);

        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        
        if($request->file('file_path')){
            $product->file_path = $request->file('file_path')->store('products');
        }

        $product->save();
        return $product;
    }

    public function searchProduct($key){
        return Product::where('name', 'Like', "%$key%")->get();
    }
}
