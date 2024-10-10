<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use Illuminate\Support\Str;

class TypetourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types= Type::Orderby('id','DESC')->where('status',1)->get();
        return view('admin.types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // dd($categories);
        return view('admin.types.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'type_name' => 'required|unique:types|max:255',
            'type_description' => 'required',
            'image' => 'required',
           
        ],[
            'type_name.required' => 'Bạn chưa nhập tiêu đề',
            'type_name.unique' => 'Tiêu đề này đã có',
            'type_description.required' => 'Bạn chưa nhập mô tả',
            'image.required' => 'Bạn chưa chọn hình ảnh',
            
        ]);
        $type = new Type();
        $type->type_name = $data['type_name'];
        $type->type_description = $data['type_description'];
        $type->status = 1;
        $get_image = $request->image;
        $path = 'upload/types/';
        $get_name_image = $get_image->getClientOriginalName();
        $name_image = current(explode('.',$get_name_image));
        $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
        $get_image->move($path,$new_image);
        $type->image= $new_image;
        $type->save();
        toastr()->success('Thêm danh mục thành công!');
        return redirect()->route('types.index');
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
        $type=Type::find($id);
        return view('admin.types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'type_name' => 'required|max:255',
            'type_description' => 'required',
          
        ],[
            'type_name.required' => 'Bạn chưa nhập tiêu đề',
            'type_name.unique' => 'Tiêu đề này đã có',
            'type_description.required' => 'Bạn chưa nhập mô tả',
            
        ]);
        $type = Type::find($id);
        $type->type_name = $data['type_name'];
        $type->type_description = $data['type_description'];
        $type->status = 1;
        $get_image = $request->image;
        if($get_image){
            $path = 'upload/types/';
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $type->image= $new_image;
        }
        $type->save();
        toastr()->success('Cập nhật thành công!');
        return redirect()->route('types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type=Type::find($id);
        $type->status=0;
        $type->save();
        toastr()->success('Xóa thành công!');
        return redirect()->route('types.index');
    }
}
