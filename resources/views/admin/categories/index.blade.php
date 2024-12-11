@extends('layouts.app')
@section('content')
<div class="card card-primary">
   <div class="card-header">
      <h3 class="card-title">Tất Cả Danh Mục</h3>
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
   <div class="card">
              <div class="card-header border-0">
                <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a>
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                  </a>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle" id="myTable">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Tiêu đề</th>
                    <th width="300">Mô tả</th>
                    {{-- <th>Hình ảnh</th> --}}
                    <th>Slug</th>
                    {{-- <th>Trạng thái</th> --}}
                    {{-- <th>Ngày tạo</th>
                    <th>Ngày cập nhật</th> --}}
                    <th>Thao tác</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($categories as $key => $cate)
                    <tr>
                        <td>{{$key}}</td>
                        <td>{{$cate->title}}</td>
                        <td>{{$cate->description}}</td>
                        {{-- <td><img src="{{asset('upload/categories/'.$cate->image)}}" alt="" width=150 height=120></td> --}}
                        <td>{{$cate->slug}}</td>
                        {{-- <td>
                            @if($cate->status==1)
                            <a href="#"><span style="color:blue; font-size:16px;" class="fa-thumb-styling fa fa-thumbs-up"></span> Hiển thị</a>
                            @else
                            <a href="#"><span style="color:red; font-size:16px;" class="fa-thumb-styling fa fa-thumbs-down"></span> Ẩn</a>
                            @endif
                        </td> --}}
                        {{-- <td>{{$cate->created_at}}</td>
                        <td>{{$cate->updated_at}}</td> --}}
                        <td>
                          <div class="btn-group">
                              <a href="{{ route('categories.edit', [$cate->id]) }}" class="btn btn-warning mr-1" title="Chỉnh sửa">
                                  <i class="fas fa-edit"></i>
                              </a>
                      
                              <form method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');" action="{{ route('categories.destroy', [$cate->id]) }}" style="display: inline;">
                                  @method('DELETE')
                                  @csrf
                                  <button type="submit" class="btn btn-danger" title="Xóa">
                                      <i class="fas fa-times"></i> <!-- Biểu tượng "Times" -->
                                  </button>
                              </form>
                          </div>
                      </td>
                      
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
</div>
@endsection