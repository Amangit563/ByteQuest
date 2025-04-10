<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    // **********************  Create Product *********************************

    public function createProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string',
            'price'       => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => "Validation Error!!!",
                'error'  => $validator->errors()
            ], 422);
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

    // ************************************  Show All Product User Wise  *****************************

    public function userShowAllProducts()
    {
        $user = Auth::guard('api')->user();
        return response()->json([
            'products' => Product::where('admin_id', $user->id)->get(),
        ]);
    }



    // ***************  Edit Modal show Data  ******************

    public function editModalShowData($id){
        $product = Product::find($id);
        return response()->json([
            'data' => $product,
        ], 200);
    }


    // ********************  Update Product  *******************

    public function productUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()
            ]);
        }
        
        $product = Product::findOrFail($id);
    
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
    
        // Image update
        if($request->hasFile('image')){

            // Purani image delete kar do
            if(Storage::exists('public/products/'.$product->image)){
                Storage::delete('public/products/'.$product->image);
            }

            // New image upload
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();

            // Upload image in storage/app/public/products
            $file->storeAs('products', $filename, 'public');  

            // Database me image name save
            $product->image = $filename;
        }// Image update
        $product->save();
    
        return response()->json([
            'status' => 200,
            'message' => 'Product Updated Successfully',
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'description' => $product->description,
                'image' => $product->image,
                'image_url' => asset('storage/products/' . $product->image),
            ],
        ]);
    }
}
