<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Session;
// use Intervention\Image;

class UserIterfaceController extends Controller
{
    public function homepage(){

        $products = Product::where('publication_status', 1)->get();
        
        return view('frontend.homepage', [
            'products' => $products,
        ]);
    }

    public function addProductPage(){
        return view('frontend.add-product-page');
    }

    protected function productValidate($req){
        $req->validate([
            'product_name' => 'required',
            'product_price' => 'required',
            'publication_status' => 'required',
        ]);
    }

    protected function imgUpload($req){
        // $img = $req->file('product_image');
        // $imgName = $img->getClientOriginalName();
        // $imgDirectory = 'product_image/';
        // $imgUrl = $imgDirectory.$imgName;
        
        // $img->move($imgDirectory, $imgName);
        // return $imgUrl;

        // $img = $req->file('product_image');
        // $imgName = $img->getClientOriginalName();
        // $imgDirectory = 'product_image/';
        // $imgUrl = $imgDirectory.$imgName;
        // Image::make($img)->resize(200, 200)->save($imgUrl);
        // return $imgUrl;

            $image = $req->file('product_image');
            $image_name=rand(10,1000000);
            $ext=strtolower($image->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='image/';
            $image_url=$upload_path.$image_full_name;
            $succes=$image->move($upload_path,$image_full_name);
            if($succes){
                return $image_url;
            }
    }

    protected function productBasicInfo($req, $imgUrl=null){
        $products = new Product;

        $products->product_name = $req->product_name;
        $products->product_price = $req->product_price;
        $products->product_color = $req->product_color;
        $products->product_image = $req->product_image;
        $products->publication_status = $req->publication_status;

        $products->save();
    }

    public function addProduct(Request $req){
        $this->productValidate($req);
        $img = $req->file('product_image');
        if($img){
            $imgUrl = $this->imgUpload($req);
            $this->productBasicInfo($req, $imgUrl);
            Session::flash('msg','Product added succesfully');
            return redirect('/add-product-page');
        }
        $this->productBasicInfo($req);
        Session::flash('msg','Product added succesfully');
        return redirect('/add-product-page');
    }


    
}
