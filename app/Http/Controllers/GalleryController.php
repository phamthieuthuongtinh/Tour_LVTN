<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Gallery;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
           
            'image' => 'required',  
            'tour_id' => 'required',
        ],[
            
            'image.required' => 'Bạn chưa chọn hình ảnh',
        ]);
       
       
        if($request->image){
            foreach($request->image as $key => $gal){
                $gallery = new Gallery();
                if (!empty($data['title'])) {
                    $gallery->title = $data['title'];
                }
                
                $gallery->tour_id = $data['tour_id'];
                $get_image = $gal;
                $path = 'upload/galleries/';
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image));
                $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                $get_image->move($path,$new_image);
                $gallery->image= $new_image;
                $gallery->save();
            }
        }
        toastr()->success('Thêm ảnh thành công!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $galleries= Gallery::where('tour_id',$id)->get();
        $tour= Tour::find($id);
        return view('admin.galleries.create',compact('tour','id','galleries')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gallery::find($id)->delete();
        toastr()->success('Xoá ảnh thành công!');
        return redirect()->back();
    }
}
