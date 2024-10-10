@extends('layouts.app')
@section('content')
<div class="card card-primary">
   <div class="card-header">
      <h3 class="card-title">Tạo Voucher</h3>
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
   <form method="POST" action="{{route('vouchers.store')}}">
    @csrf
      <div class="card-body">
         <div class="form-group">
            <label for="exampleInputEmail1">Tiêu đề Voucher</label>
            <input type="text" class="form-control" name="voucher_name" id="exampleInputEmail1" placeholder="...">
         </div>
         <div class="form-group">
            <label for="exampleInputEmail1">Mã</label>
            <input type="text" class="form-control" name="voucher_code" id="exampleInputEmail1" placeholder="...">
         </div>
         <div class="form-group">
            <label for="exampleInputPassword1">Số lượt dùng</label>
            <input type="number" class="form-control" name="voucher_time" id="exampleInputPassword1" placeholder="...">
         </div>
         
         <div class="form-group">
            <label for="exampleInputEmail1">Loại giảm</label>
            <select class="form-control" name="voucher_condition">
               <option value="0">Giảm theo %</option>
               <option value="1">Giảm theo số tiền</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Giá trị giảm</label>
            <input type="text" class="form-control" name="voucher_number" id="exampleInputEmail1" placeholder="...">
         </div>
        
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
         <button type="submit" class="btn btn-primary">Tạo</button>
      </div>
   </form>
</div>
@endsection