@extends('layouts.app')
@section('content')
<div class="card card-primary">
   <div class="card-header">
      <h3 class="card-title">Tạo tài khoản doanh nghiệp</h3>
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
   <form method="POST" action="{{route('admin.create_account_business')}}" enctype="multipart/form-data">
    @method("POST")
    @csrf
      <div class="card-body">
        <div class="form-group">
            <label for="exampleInputEmail1">Tên doanh nghiệp</label>
            <input type="text" class="form-control" value="{{$register->company_name}}" readonly name="company_name" id="exampleInputEmail1">
         </div>
         <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="text" class="form-control" value="{{$register->email}}" readonly name="email" id="exampleInputEmail1">
         </div>
         <div class="form-group">
            <label for="password1">Mật khẩu</label>
            <input type="password" class="form-control" name="password1" id="password1" placeholder="Mật khẩu">
            
         </div>
         <div class="form-group">
            <label for="password2">Nhập lại mật khẩu</label>
            <input type="password" class="form-control" name="password2" id="password2" placeholder="Nhập lại mật khẩu">
         </div>
         <input type="hidden" name="register_id" value="{{$register->id}}">
     
    </div>
      <!-- /.card-body -->
      <div class="card-footer">
         <button type="submit" class="btn btn-primary">Tạo</button>
      </div>
   </form>
</div>
@endsection