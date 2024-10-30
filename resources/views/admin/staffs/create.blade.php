@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Thêm nhân viên</h3>
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
        <form method="POST" action="{{ route('staffs.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Tên</label>
                    <input type="text" class="form-control" name="name" id="exampleInputEmail1" placeholder="...">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Giới tính</label>
                    <select class="form-control" name="sex">
                        <option value="0">Nam</option>
                        <option value="1">Nữ</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Vị trí</label>
                    <select class="form-control" name="position">
                        <option value="0">Hướng dẫn viên du lịch</option>
                      
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Email</label>
                    <input type="email" class="form-control" name="email" id="exampleInputPassword1"
                        placeholder="...">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Phone</label>
                    <input type="phone" class="form-control" name="phone" id="exampleInputPassword1"
                        placeholder="...">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Địa chỉ</label>
                    <input type="text" class="form-control" name="address" id="exampleInputPassword1"
                        placeholder="...">
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Hình ảnh</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="image" class="form-control-file" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Chọn hình ảnh</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Mức lương</label>
                    <input type="text" class="form-control" name="salary" id="exampleInputPassword1"
                        placeholder="...">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Ngày bắt đầu làm việc</label>
                    <input type="date" class="form-control" name="hireday" id="exampleInputPassword1"
                        placeholder="...">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Ngày sinh</label>
                    <input type="date" class="form-control" name="birthday" id="exampleInputPassword1"
                        placeholder="...">
                </div>
                
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Tạo</button>
            </div>
        </form>
    </div>
@endsection
