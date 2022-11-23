<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller {
    public function index(){
        $products = Product::all();
        return response()->json(['status' => 200, 'products' => $products]);
    }
    public function create(Request $request){
        $validator = Validator::make($request->all(), 
            [
                'productName' => 'required | max:200',
                'productDescription' => 'required | max:200',
                'productPrice' => 'required',
                'productStock' => 'required',
            ]     
        );
        if($validator->fails()){
            return response()->json(['status' => 422, 'validate_error' => $validator -> errors()]);
        } else {
            $product = new Product();
            $product->productName = $request->input('productName');
            $product->productDescription = $request->input('productDescription');
            $product->productPrice = $request->input('productPrice');
            $product->productStock = $request->input('productStock');
            $product->save();

            return response()->json(['status' => 200, 'message' => 'Added successfully']);
        }
    }
}
