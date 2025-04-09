<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProductController extends Controller
{
    public function createProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string',
            'price'       => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => "Validation Error!!!",'error'  => $validator->errors()], 422);
        }

        $imageName = null;

        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            // Store the image in the 'public/products' directory using the 'public' disk
            $request->image->storeAs('products', $imageName, 'public');
            $imageName = $imageName;
        }

        $product = Product::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'description' => $request->description,
            'image'       => $imageName,
            'admin_id'    => auth()->user()->id,
        ]);

        return response()->json([
            'status'  => 200,
            'message' => ' ✅ Product Created Successfully',
            'data'    => $product
        ]);
    }

    // API Show Products
    public function apiShowProducts()
    {
        $admin = Auth::guard('api')->user();
        return response()->json([
            'products' => Product::where('admin_id', $admin->id)->get(),
        ]);
    }

    // ***************  Edit Modal show Data  ******************

    public function editModalShowData($id){
        $product = Product::find($id);
        return response()->json([
            'data' => $product,
        ], 200);
    }


    public function productUpdate(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $product->name = $request->name;
    $product->price = $request->price;
    $product->description = $request->description;

    // Check if image file exists
    if ($request->hasFile('image')) {
        
        // Delete Old Image
        if($product->image){
            Storage::delete('public/products/'.$product->image);
        }

        // Store New Image
        $file = $request->file('image');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->storeAs('public/products/', $filename);
        $product->image = $filename;
    }

    $product->save();

    return response()->json([
        'status' => 200,
        'message' => 'Product Updated Successfully',
        'data' => [
            'name' => $product->name,
            'price' => $product->price,
            'description' => $product->description,
            'image_url' => asset('storage/products/'.$product->image),
        ]
    ]);
}
}
