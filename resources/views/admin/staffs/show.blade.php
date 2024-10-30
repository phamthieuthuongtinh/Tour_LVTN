@extends('layouts.app')
@section('content')
<div class="card card-primary">
   <div class="card-header">
      <h3 class="card-title">Thông tin nhân viên</h3>
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
   <div class="container my-5">
   
    <div class="card p-4 shadow">
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="{{ asset('upload/staffs/' . $staff->image) }}" alt="Ảnh nhân viên" class="img-fluid rounded" width="200" height="220">
            </div>
            <div class="col-md-8">
                <h4>Thông Tin Chi Tiết</h4>
                <table class="table table-borderless">
                    <tr>
                        <th>Họ và tên:</th>
                        <td>{{ $staff->name }}</td>
                    </tr>
                    <tr>
                      <th>Giới tính:</th>
                      <td>
                          @if($staff->sex == 0)
                              Nam
                          @else
                              Nữ
                          @endif
                      </td>
                  </tr>
                  <tr>
                    <th>Ngày sinh:</th>
                    <td>{{ $staff->birthday }}</td>
                  </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $staff->email }}</td>
                    </tr>
                    <tr>
                        <th>Số điện thoại:</th>
                        <td>{{ $staff->phone }}</td>
                    </tr>
                    <tr>
                      <th>Địa chỉ:</th>
                      <td>{{ $staff->address }}</td>
                    </tr>
                    <tr>
                        <th>Vị trí:</th>
                        <td>
                            @if($staff->position == 0)
                                Hướng Dẫn Viên
                            @else
                                Nhân Viên Chưa Xác Định
                            @endif
                        </td>
                    </tr>
                    <tr>
                      <th>Ngày bắt đầu làm việc:</th>
                      <td>{{ $staff->hireday }}</td>
                    </tr>
                    <tr>
                      <th>Mức lương:</th>
                      <td>{{ number_format($staff->salary) }} vnđ</td>
                    </tr>
                    
                </table>
                <a href="{{ route('staffs.edit', $staff->id) }}" class="btn btn-warning mt-3">Chỉnh sửa</a>
            </div>
        </div>
    </div>
</div>
</div>
@endsection