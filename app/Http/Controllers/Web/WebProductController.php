<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class WebProductController extends Controller
{

    // *********************  Product PAge Show ***********************
    public function showAllProducts()
    {
        $admin = Auth::user();
        $products = Product::where('admin_id', $admin->id)->get();
        return view('AddProduct', compact('products'));
    }


    // **********************  Show Dashboard PAge  *********************

    public function dashboard(){
        $users = User::get();
        $latestUsers = User::get();
        
        $admin = Auth::user();
        $latestProducts = Product::where('admin_id', $admin->id)->get();

        return view('home', compact('users', 'latestUsers', 'latestProducts'));
    }


    // ************************  Product Delete  *********************

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product Not Found!'
            ]);
        }

            // Image path check & delete
        if ($product->image) {
            $imagePath = public_path('storage/products/' . $product->image);
            
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete image from folder
            }
        }

        $product->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Product Deleted Successfully!'
        ]);
    }
}
