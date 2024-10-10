@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Chỉnh sửa bài blog</h3>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{route('blogs.update',[$blog->id])}}" enctype="multipart/form-data">
            @method("PUT")
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Tiêu đề</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Nhập tiêu đề bài blog" value="{{$blog->title}}">
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Hình ảnh</label>
                    <div class="input-group">
                       <div class="custom-file">
                          <input type="file" name="image" class="form-control-file" id="exampleInputFile">
                          <label class="custom-file-label" for="exampleInputFile">Chọn hình ảnh</label>
                          
                       </div>
                       
                       <img src="{{asset('upload/blogs/'.$blog->image)}}" alt="" width=150 height=120>
                    </div>
                 </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Thuộc danh mục</label>
                    <select class="form-control" name="category">
                        <option  {{1==$blog->category ? 'selected':''}} value="1">Tin tức du lịch</option>
                        <option {{2==$blog->category ? 'selected':''}} value="2">Cẩm nang du lịch</option>
                        <option  {{3==$blog->category ? 'selected':''}}value="3">Kinh nghiệm du lịch</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Mô tả</label>
                    <input type="text" class="form-control" id="description" value="{{$blog->description}}" name="description" placeholder="Nhập mô tả bài blog">
                </div>
                <div class="form-group">
                    <label for="content">Nội dung</label>
                    <textarea id="content" class="form-control" name="content">{!!$blog->content!!}</textarea>
                </div>
               

                <button type="submit"  class="btn btn-primary">Lưu</button>
            </div>

        </form>
        
    </div>
@endsection
