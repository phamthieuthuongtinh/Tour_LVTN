@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Sửa thông tin nhân viên</h3>
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
        <form method="POST" action="{{ route('staffs.update',[$staff->id]) }}" enctype="multipart/form-data">
            @method("PUT")
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Tên</label>
                    <input type="text" value="{{$staff->name}}" class="form-control" name="name" id="exampleInputEmail1" placeholder="...">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Giới tính</label>
                    <select class="form-control" name="sex">
                        <option {{$staff->sex==0 ? 'selected':''}} value="{{$staff->sex}}">Nam</option>
                        <option {{$staff->sex==1 ? 'selected':''}} value="{{$staff->sex}}">Nữ</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Vị trí</label>
                    <select class="form-control" name="position">
                        <option {{$staff->position==0 ? 'selected':''}} value="{{$staff->position}}">Hướng dẫn viên du lịch</option>
                      
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Email</label>
                    <input type="email" class="form-control" value="{{$staff->email}}" name="email" id="exampleInputPassword1"
                        placeholder="...">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Phone</label>
                    <input type="phone" class="form-control" value="{{$staff->phone}}" name="phone" id="exampleInputPassword1"
                        placeholder="...">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Địa chỉ</label>
                    <input type="text" class="form-control" value="{{$staff->address}}" name="address" id="exampleInputPassword1"
                        placeholder="...">
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Hình ảnh</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="image" class="form-control-file" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Chọn hình ảnh</label>
                        </div>
                        <img src="{{asset('upload/staffs/'.$staff->image)}}" alt="" width=150 height=120>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Mức lương</label>
                    <input type="text" class="form-control" value="{{$staff->salary}}" name="salary" id="exampleInputPassword1"
                        placeholder="...">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Ngày bắt đầu làm việc</label>
                    <input type="date" class="form-control" value="{{$staff->hireday}}" name="hireday" id="exampleInputPassword1"
                        placeholder="...">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Ngày sinh</label>
                    <input type="date" class="form-control" value="{{$staff->birthday}}" name="birthday" id="exampleInputPassword1"
                        placeholder="...">
                </div>
                
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </div>
        </form>
    </div>
@endsection
