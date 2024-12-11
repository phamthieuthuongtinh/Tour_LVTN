<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;

class BannersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners= Banner::Orderby('banner_id','DESC')->get();
        return view('admin.banners.index',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'banner_title' => 'required|unique:banners',
            'banner_content' => 'required',
            'banner_image' => 'required',
            
        ],[
            'banner_title.required' => 'Bạn chưa nhập tiêu đề',
            'banner_title.unique' => 'Tiêu đề này đã có',
            'banner_content.required' => 'Bạn chưa nhập mô tả',
            'banner_image.required' => 'Bạn chưa chọn hình ảnh',
            
        ]);
        $banner = new Banner();
        $banner->banner_title = $data['banner_title'];
        $banner->banner_content = $data['banner_content'];
        
        $get_image = $request->banner_image;
        $path = 'upload/banners/';
        $get_name_image = $get_image->getClientOriginalName();
        $name_image = current(explode('.',$get_name_image));
        $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
        $get_image->move($path,$new_image);
        $banner->banner_image= $new_image;

        $banner->save();
        toastr()->success('Tạo banner thành công!',['positionClass' => 'toast-bottom-right']);
        return redirect()->route('banners.index');
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
        $banner= Banner::where('banner_id',$id)->first();
        return view('admin.banners.edit',compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data = $request->validate([
            'banner_title' => 'required',
            'banner_content' => 'required',
         
        ],[
            'banner_title.required' => 'Bạn chưa nhập tiêu đề',
          
            'banner_content.required' => 'Bạn chưa nhập mô tả',
            
        ]);
        
        $banner= Banner::where('banner_id',$id)->first();
        $banner->banner_title = $data['banner_title'];
        $banner->banner_content = $data['banner_content'];
        
        if($request->image){
            $get_image = $request->image;
            $path = 'upload/banners/';
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $banner->banner_image= $new_image;
        }
        
        toastr()->success('Cập nhật thành công!');
        $banner->save();
        return redirect()->route('banners.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner=Banner::find($id);
        $banner->delete();
        toastr()->success('Xóa banner thành công!');
        return redirect()->route('banners.index');
    }
}
