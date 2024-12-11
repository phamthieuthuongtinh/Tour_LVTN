@extends('layouts.app')
@section('content')
<div class="card card-primary">
   <div class="card-header">
      <h3 class="card-title">Chỉnh sửa banner</h3>
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
   <!-- /.card-header -->
   <!-- form start -->
   <form method="POST" action="{{route('banners.update',[$banner->banner_id])}}" enctype="multipart/form-data">
      @method("PUT")
    @csrf
      <div class="card-body">
         <div class="form-group">
            <label for="exampleInputEmail1">Tiêu đề</label>
            <input type="text" class="form-control" name="banner_title" id="exampleInputEmail1" value="{{$banner->banner_title}}">
         </div>
         <div class="form-group">
            <label for="exampleInputPassword1">Nội dung</label>
            <input type="text" class="form-control" name="banner_content" id="exampleInputPassword1" value="{{$banner->banner_content}}">
         </div>
         <div class="form-group">
            <label for="exampleInputFile">Hình ảnh</label>
            <div class="input-group">
               <div class="custom-file">
                  <input type="file" name="banner_image" class="form-control-file" id="exampleInputFile">
                  <label class="custom-file-label" for="exampleInputFile">Chọn hình ảnh</label>
               </div>
               <img src="{{asset('upload/banners/'.$banner->banner_image)}}" alt="" width=150 height=120>
            </div>
         </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
         <button type="submit" class="btn btn-primary">Cập nhật</button>
      </div>
   </form>
</div>
@endsection