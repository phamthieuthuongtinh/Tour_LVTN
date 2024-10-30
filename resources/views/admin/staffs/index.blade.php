@extends('layouts.app')
@section('content')
<div class="card card-primary">
   <div class="card-header">
      <h3 class="card-title">Tất Cả Nhân Viên</h3>
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
                    <th>Hình ảnh</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>SDT </th>
                    <th>Vị trí</th>
                    <th>Giới tính</th>
                    <th>Thao tác</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($staffs as $key => $staff)
                    <tr>
                        <td>{{$key}}</td>
                        <td><img src="{{asset('upload/staffs/'.$staff->image)}}" alt="" width=100 height=110></td>
                        <td>{{$staff->name}}</td>
                        <td>{{$staff->email}}</td>
                        
                        <td>{{$staff->phone}}</td>
                        <td>
                            @if($staff->position==0)
                             Tour Guide
                            @else
                            Nhân viên chưa xác định
                            @endif
                        </td>
                        <td>
                            @if($staff->sex==0)
                             Nam
                            @else
                              Nữ
                            @endif
                        </td>
                       
                        <td>
                          <div class="btn-group">
                            <a href="{{ route('staffs.show', [$staff->id]) }}" class="btn btn-info mr-1" title="Xem thông tin">
                                <i class="fas fa-eye"></i>
                                </a>
                              <a href="{{ route('staffs.edit', [$staff->id]) }}" class="btn btn-warning mr-1" title="Chỉnh sửa">
                                  <i class="fas fa-edit"></i>
                              </a>
                              <a href="{{ route('staffs.manage_task', [$staff->id]) }}" class="btn btn-success mr-1" title="Quản lý">
                                <i class="fas fa-tasks"></i>
                            </a>
                              <form method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa nhân viên này?');" action="{{ route('staffs.destroy', [$staff->id]) }}" style="display: inline;">
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