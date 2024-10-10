@extends('layouts.app')
@section('content')
<div class="card card-primary">
   <div class="card-header">
      <h3 class="card-title">Tất Cả Banner</h3>
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
                    <th>Nội dung</th>
                    <th>Hình ảnh</th>
                    <th>Ngày tạo</th>
                    <th>Ngày cập nhật</th>
                    <th>Thao tác</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($banners as $key => $ban)
                    <tr>
                        <td>{{$key}}</td>
                        <td>{{$ban->banner_title}}</td>
                        <td>{{$ban->banner_content}}</td>
                        <td><img src="{{asset('upload/banners/'.$ban->banner_image)}}" alt="" width=150 height=120></td>
     
                       
                        <td>{{$ban->created_at}}</td>
                        <td>{{$ban->updated_at}}</td>
                        <td>
                          <div class="btn-group">
                            <a href="{{route('banners.edit',[$ban->banner_id])}}" class="btn btn-warning mr-2" title="Chỉnh sửa" > 
                              <i class="fas fa-edit"></i>
                            </a>
                       
                            <form method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');" action="{{route('banners.destroy',[$ban->banner_id])}}">
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