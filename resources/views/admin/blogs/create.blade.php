@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Tạo bài blog</h3>
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
        <form method="POST" action="{{route('blogs.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Tiêu đề</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Nhập tiêu đề bài blog">
                </div>
                
                <div class="form-group">
                    <label for="image">Hình ảnh</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Thuộc danh mục</label>
                    <select class="form-control" name="category">
                        <option value="1">Tin tức du lịch</option>
                        <option value="2">Cẩm nang du lịch</option>
                        <option value="3">Kinh nghiệm du lịch</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Mô tả</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Nhập mô tả bài blog">
                </div>
                <div class="form-group">
                    <label for="content">Nội dung</label>
                    <textarea id="content" class="form-control" name="content"></textarea>
                </div>

                <button type="submit"  class="btn btn-primary">Lưu</button>
            </div>

        </form>
        
    </div>
@endsection
