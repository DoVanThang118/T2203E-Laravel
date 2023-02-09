<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function listAll(){
//        $data = Product::all();// collection Product object
        // offset = (page-1) * limit
        //$data = Product::limit(20)->offset(20)->get();
        //$data = Product::limit(20)->orderBy("id","desc")->get();
        $data = Product::orderBy("id","desc")->paginate(20);

        //return view("admin.product.list",compact('data'));
        return view("admin.product.list",[
            "data"=>$data
        ]);
    }

    public function create(){
        $categories = Category::all();
        return view("admin.product.create",compact("categories"));
    }

    public function store(Request $request){
        $request->validate([
           "name"=>"required|string|min:6",
            "price"=>"required|numeric|min:0",
            "qty"=>"required|numeric|min:0",
            "category_id"=>"required"
        ],[
            "required"=>"Vui lòng nhập thông tin",
            "string"=>"Vui lòng nhập vào một chuỗi",
            "min"=>"Phải nhập :attribute tối thiểu :min"
        ]);

        $thumbnail = null;
        if ($request->hasFile("thumbnail")){
            $file = $request->file("thumbnail");
            $fileName = $file->getClientOriginalName();
            //$ext = $file->getClientOriginalExtension();
            $path = public_path("uploads");
            $file->move($path,$fileName);
            $thumbnail = "uploads/".$fileName;
        }

        Product::create([
            "name"=>$request->get("name"),
            "price"=>$request->get("price"),
            "thumbnail"=>$thumbnail,
            "description"=>$request->get("description"),
            "qty"=>$request->get("qty"),
            "category_id"=>$request->get("category_id")
        ]);
        return redirect()->to("admin/product");
    }
}
