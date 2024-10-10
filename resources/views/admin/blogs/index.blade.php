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
                    <th>Loại</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($blogs as $key => $blog)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$blog->title}}</td>
                        <td>
                            @if($blog->category==1)
                            Tin tức du lịch
                            @elseif($blog->category==2)
                            Cẩm nang du lịch
                            @else
                            Kinh nghiệm du lịch
                            @endif
                        </td>
                        <td>{{$blog->created_at}}</td>
                       
                        <td>
                          <div class="btn-group">
                              <a href="{{ route('blogs.edit', [$blog->id]) }}" class="btn btn-warning mr-1" title="Chỉnh sửa">
                                  <i class="fas fa-edit"></i>
                              </a>
                      
                              <form method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa bài này?');" action="{{ route('blogs.destroy', [$blog->id]) }}" style="display: inline;">
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