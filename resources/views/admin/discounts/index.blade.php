@extends('layouts.app')
@section('content')
<div class="card card-primary">
   <div class="card-header">
      <h3 class="card-title">Tất Cả Tour Đang Giảm Giá</h3>
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
                    <th>Tên tour</th>
                    <th>Loại tour</th>
                    <th>Địa điểm</th>
                    <th>Ti lệ</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Thao tác</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($discount as $key => $dis)
                    <tr>
                        <td>{{$key}}</td>
                        <td>{{$dis->tour->title}}</td>
                        <td>{{$dis->tour->type->type_name}}</td>
                       
                        <td>{{$dis->tour->category->title}}</td>
                        
                        <td>{{$dis->rate}}%</td>
                        <td>{{$dis->start}}</td>
                        <td>{{$dis->end}}</td>
                        <td>
                          <div class="btn-group">
                              <a href="{{ route('discounts.edit', [$dis->id]) }}" class="btn btn-info mr-1" title="Xem chi tiết">
                                  <i class="fas fa-eye"></i>
                              </a>
                      
                              <form method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');" action="{{ route('discounts.destroy', [$dis->id]) }}" style="display: inline;">
                                  @method('DELETE')
                                  @csrf
                                  <button type="submit" class="btn btn-danger" title="Xóa">
                                      <i class="fas fa-trash"></i> <!-- Biểu tượng "Times" -->
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