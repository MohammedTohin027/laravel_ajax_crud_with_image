<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;

class CategoryController extends Controller
{
    public function index(){
        $data = Category::orderBy('id', 'desc')->get();
        return view('category.category', compact('data'));
    }

    public function store(Request $request){
        if ($request->hasFile('image')) {
            $image = $request->image;
            $image_name = hexdec(uniqid()).octdec(uniqid()).'.'.$image->getClientOriginalExtension();    
            $savePath = 'images/category/'.$image_name;
            Image::make($image)->resize(180,180)->save($savePath);
        }

        $data = [
            'cat_name_en' => $request->cat_name_en, 
            'cat_name_bn' => $request->cat_name_bn, 
            'cat_slug_en' => strtolower(str_replace(' ', '-', $request->cat_name_en)), 'cat_slug_bn' => strtolower(str_replace(' ', '-', $request->cat_name_bn)), 'discount' => $request->discount, 
            'image'=> $savePath, 
            'created_at' => Carbon::now(),
        ];

        Category::insert($data);

        return response()->json(
            [
                'status' => '200',
                'message' => 'Category saved successfully!',
            ]
        );
    }
}
