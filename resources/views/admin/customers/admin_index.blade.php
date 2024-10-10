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
                    <th>Tên Khách hàng</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Trạng thái</th>
                    <th>Ngày đăng ký</th>
                    <th>Thao tác</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($customers as $key => $reg)
                    <tr>
                        <td>{{$key}}</td>
                        <td>{{$reg->customer_name}}</td>
                        <td>{{$reg->email}}</td>
                        <td>{{$reg->phone}}</td>
                        {{-- <td>
                            @if($cate->status==1)
                            <a href="#"><span style="color:blue; font-size:16px;" class="fa-thumb-styling fa fa-thumbs-up"></span> Hiển thị</a>
                            @else
                            <a href="#"><span style="color:red; font-size:16px;" class="fa-thumb-styling fa fa-thumbs-down"></span> Ẩn</a>
                            @endif
                        </td> --}}
                        <td>
                            @if($reg->status==1)
                                Còn hoạt động
                            @elseif($reg->status==0)
                                Dừng hoạt động
                            @endif
                        </td>
                        <td>{{$reg->created_at}}</td>
                       
                        <td>
                            @if($reg->status==1)
                                <form method="POST" onsubmit="return confirm('Bạn có chắc xóa?');" action="{{route('admin.destroy_customer',[$reg->customer_id])}}">
                               
                                    @csrf
                                    <button type="submit" class="btn btn-danger" title="Xóa tài khoản">
                                      <i class="fas fa-times"></i> <!-- Biểu tượng "Times" -->
                                  </button>
                                </form>
                            @else
                            <form method="POST"  action="{{route('admin.destroy_customer',[$reg->customer_id])}}">
                
                                @csrf
                            <input type="submit" class="btn btn-warning" value="Khôi phục">
                            </form>
                        
                            
                            @endif
                            
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
</div>
@endsection