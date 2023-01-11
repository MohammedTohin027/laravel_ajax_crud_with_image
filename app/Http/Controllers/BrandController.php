<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Brand;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    //  brand view
    public function index(){
        $data = Brand::orderBy('id', 'desc')->get();
        return view('brand.index', compact('data'));
    }

    //  brand store
    public function store(Request $request) {
        if ($request->hasFile('brand_image')) {
            $image = $request->brand_image;
            $image_name = hexdec(uniqid()).octdec(uniqid()).'.'.$image->getClientOriginalName();
            $savePath = 'images/brands/'.$image_name;
            Image::make($image)->resize(180, 180)->save($savePath);
        }
        $data = [
            'brand_name_en' => $request->brand_name_en,
            'brand_name_bn' => $request->brand_name_bn,
            'brand_image' => $savePath,
            'created_at' => Carbon::now(),
        ];
        Brand::insert($data);
        return response()->json([
            'status' => 200,
            'message' => 'Brand saved successfully!',
        ]);
    }

    //  Brand Edit
    public function edit(Request $request){
        $data = Brand::FindOrFail($request->module_id);
        return response()->json($data);
    }

    //  Brand Update
    public function update(Request $request){
        if ($request->hasFile('brand_image')) {
            $image = $request->brand_image;
            $image_name = hexdec(uniqid()).octdec(uniqid()).'.'.$image->getClientOriginalName();
            $savePath = 'images/brands/'.$image_name;
            Image::make($image)->resize(180, 180)->save($savePath);
            @unlink($request->old_image);
        }
        else{
            $savePath = $request->old_image;
        }

        Brand::where('id', $request->brand_id)->update([
            'brand_name_en' => $request->brand_name_en,
            'brand_name_bn' => $request->brand_name_bn,
            'brand_image' => $savePath,
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Brand updated successfully!',
        ]);
    }

}
