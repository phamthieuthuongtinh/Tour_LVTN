<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories= Category::Orderby('id','DESC')->where('status',1)->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $categories= Category::Orderby('id','DESC')->get();
        $categories = $this->getCategoriesProduct();
        // dd($categories);
        return view('admin.categories.create', compact('categories'));
    }
    public function getCategoriesProduct(){
        $categories= Category::orderBy('id','DESC')->get();
        $listCategory=[];
        Category::recursive($categories,$parents=0,$level=1,$listCategory);
        return $listCategory;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|unique:categories|max:255',
            'description' => 'required',
            'image' => 'required',
            'status' => 'required',
            'category_parent' => 'required',
        ],[
            'title.required' => 'Bạn chưa nhập tiêu đề',
            'title.unique' => 'Tiêu đề này đã có',
            'description.required' => 'Bạn chưa nhập mô tả',
            'image.required' => 'Bạn chưa chọn hình ảnh',
            'status.required' => 'Bạn chưa chọn trạng thái hiển thị',
            
        ]);
        $category = new Category();
        $category->title = $data['title'];
        $category->category_parent = $data['category_parent'];
        $category->description = $data['description'];
        $category->status = 1;
        $category->slug =  Str::slug($data['title']);
        
        $get_image = $request->image;
        $path = 'upload/categories/';
        $get_name_image = $get_image->getClientOriginalName();
        $name_image = current(explode('.',$get_name_image));
        $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
        $get_image->move($path,$new_image);
        $category->image= $new_image;

        $category->save();
        toastr()->success('Thêm danh mục thành công!');
        return redirect()->route('categories.index');
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
        $categories = $this->getCategoriesProduct();
        $category=Category::find($id);
        return view('admin.categories.edit', compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category_parent' => 'required',
            'status' => 'required',
        ],[
            'title.required' => 'Bạn chưa nhập tiêu đề',
            
            'description.required' => 'Bạn chưa nhập mô tả',
      
            'status.required' => 'Bạn chưa chọn trạng thái hiển thị',
            
        ]);
        $category = Category::find($id);
        $category->title = $data['title'];
        $category->category_parent = $data['category_parent'];
        $category->description = $data['description'];
        $category->status = $data['status'];
        $category->slug =  Str::slug($data['title']);
        
        
        if($request->image){
            $get_image = $request->image;
            $path = 'upload/categories/';
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $category->image= $new_image;
        }
        
        toastr()->success('Cập nhật thành công!');
        $category->save();
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categories=Category::find($id);
        $categories->status=0;
        $categories->save();
        toastr()->success('Xóa thành công!');
        return redirect()->route('categories.index');
    }
}
