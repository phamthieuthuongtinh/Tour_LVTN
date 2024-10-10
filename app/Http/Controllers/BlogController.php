<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs=Blog::orderBy('id','DESC')->get();
        return view('admin.blogs.index',compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category' => 'required',
            'description' => 'required',
        ]);

        // Create new blog instance\
        $content = $this->updateImagePaths($request->input('content'));
        $blog = new Blog();
        
        $blog->title = $request->input('title');
        $blog->content = $content;
        $blog->category = $request->input('category');
        $blog->description = $request->input('description');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/blogs'), $filename);
            $blog->image = $filename;
        }
        // Save the blog
        $blog->save();
        toastr()->success('Thêm thành công!');
        return redirect()->route('blogs.index');

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
        $blog=Blog::find($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category' => 'required',
            'description' => 'required',
        ]);

        // Create new blog instance\
        $content = $this->updateImagePaths($request->input('content'));
        $blog = Blog::find($id);
        
        $blog->title = $request->input('title');
        $blog->content = $content;
        $blog->category = $request->input('category');
        $blog->description = $request->input('description');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/blogs'), $filename);
            $blog->image = $filename;
        }
        // Save the blog
        $blog->save();
        toastr()->success('Cập nhật thành công!');
        return redirect()->route('blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog=Blog::find($id);
        $blog->delete();
        toastr()->success('Xóa thành công!');
        return redirect()->route('blogs.index');
    }
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('upload/blogs'), $filename); // Cập nhật đường dẫn

            return response()->json(['location' => asset('upload/blogs/' . $filename)]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }
    // Trong Controller hoặc một helper
    protected function updateImagePaths($content)
    {
        // Thay thế tất cả các đường dẫn hình ảnh tương đối thành đường dẫn tuyệt đối
        return preg_replace('/src="\.\.\/upload\/blogs\/([^"]+)"/', 'src="' . asset('upload/blogs/$1') . '"', $content);
    }
    public function tintuc(){
        $blogs=Blog::where('category',1)->paginate(3);
        return view('pages.blog_tintuc',compact('blogs'));
    }
    public function camnang(){
        $blogs=Blog::where('category',2)->paginate(3);
        return view('pages.blog_tintuc',compact('blogs'));
    }
    public function kinhnghiem(){
        $blogs=Blog::where('category',3)->paginate(3);
        return view('pages.blog_tintuc',compact('blogs'));
    }
    public function detail_blog(string $id){
        $blog=Blog::find($id);
        return view('pages.detail_blog',compact('blog'));
    }

}
